<?php

namespace App\Livewire;


use App\Models\Debtor;
use App\Models\Installment;
use App\Models\InstallmentItem;
use App\Models\InstallmentPlan;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\InstallmentReminderNotification;
use App\Notifications\OrderCreatedNotification;
use App\Services\PayPalService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
class ScanProduct extends Component
{
    public $barcode;
    public $installments;
    public $down_payment;
    public $start_date;

    public $users;
    public $payment_type;
    public $selected_user_id;
    public $selected_installments_id;
    public $product;
    public $quantity = 1;
    protected $payPalService;
    public $cart = [];
    public $is_debtor = false;
    public ?string $customer_name = '';

    public function boot(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }
    public function mount($users, $installments)
    {
        $this->cart = session('cart', []);
        $this->users = $users;
        $this->installments = $installments;
    }

    public function updatedBarcode()
    {
        $this->product = Product::where('barcode', $this->barcode)->first();




    }
    public function updatedCart()
    {
        session(['cart' => $this->cart]);
    }
    public function updateQuantity($index, $newQuantity)
    {
        $cart = session('cart');

        if (!isset($cart[$index]['id'])) {
            session()->flash('error', 'حدث خطأ: المنتج غير موجود بشكل صحيح.');
            return;
        }

        $productId = $cart[$index]['id'];
        $product = Product::find($productId);

        if ($product && $newQuantity > $product->quantity) {
            session()->flash('error', 'الكمية الجديدة أكبر من المتوفر.');
            return;
        }

        $cart[$index]['quantity'] = $newQuantity;
        session(['cart' => $cart]);
        $this->cart = $cart;
    }
    public function syncCart($index)
    {
        if (!isset($this->cart[$index]))
            return;

        $item = $this->cart[$index];
        $product = Product::find($item['id']);

        if ($product && $item['quantity'] > $product->quantity) {
            session()->flash('error', 'الكمية أكبر من المتوفر.');
            return;
        }

        // حدث الـ session
        session()->put('cart', $this->cart);
        session()->flash('success', 'تم تحديث الكمية بنجاح.');
    }

    public function addToCart()
    {
        if (!$this->product) {
            session()->flash('error', 'المنتج غير موجود.');
            return;
        }

        $cart = session('cart', []);

        // 🔍 تحقق إذا كان المنتج موجود بالفعل في السلة عن طريق الباركود
        foreach ($cart as $item) {
            if ($item['id'] === $this->product->id) {
                session()->flash('error', 'المنتج موجود بالفعل في السلة.');
                return;
            }
        }

        // 🛒 إضافة المنتج للسلة
        $cart[] = [
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => $this->quantity,
        ];

        session(['cart' => $cart]);
        $this->cart = $cart;

        $this->reset(['barcode', 'product', 'quantity']);
        session()->flash('success', 'تمت الإضافة إلى السلة بنجاح.');
    }




    public function removeItem($index)
    {
        $cart = session('cart', []);

        // تأكد إن العنصر موجود
        if (isset($cart[$index])) {
            unset($cart[$index]);

            // أعد ترتيب الـ array من أول وجديد
            $cart = array_values($cart);

            // حدث الجلسة و Livewire
            session(['cart' => $cart]);
            $this->cart = $cart;

            session()->flash('success', 'تم حذف المنتج من السلة.');
        } else {
            session()->flash('error', 'لم يتم العثور على هذا المنتج.');
        }
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }
   
    public function confirmOrder()
    {
        $cart = session('cart', []);

        if (empty($cart) || empty($this->selected_user_id)) {
            session()->flash('error', empty($cart) ? 'السلة فارغة.' : 'برجاء اختيار عميل');
            return;
        }

        DB::beginTransaction();

        try {               
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            // 1. إنشاء الطلب
            $order = Order::create([
                'user_id' => $this->selected_user_id,
                'total' => $total,
                'employee_id' => auth()->id(),
                'payment_type' => $this->payment_type,
                'paid_amount' => $this->payment_type === 'cash' ? $total : $this->down_payment,
            ]);


            // 2. إنشاء الأصناف وتحديث الكميات
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if (!$product || $item['quantity'] > $product->quantity) {
                    throw new \Exception('الكمية غير متوفرة: ' . $item['name']);
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                    'employee_id' => auth()->id(),
                ]);
                $product->decrement('quantity', $item['quantity']);
            }

            $paymentLink = null;

            // 3. حالة الدفع النقدي (CASH)
            if ($this->payment_type === 'cache') {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $total,
                    'method' => 'cash',
                    'payment_date' => now(),
                ]);
            } 


           

            
            // 4. حالة الأقساط (INSTALLMENT / PAYPAL)
            else {
                $plan = InstallmentPlan::find($this->selected_installments_id);
                $totalWithInterest = $total + ($total * $plan->interest_rate / 100);

                $installment = Installment::create([
                    'order_id' => $order->id,
                    'plan_id' => $plan->id,
                    'total_with_interest' => $totalWithInterest,
                    'down_payment' => $this->down_payment,
                    'remaining_amount' => $totalWithInterest - $this->down_payment,
                    'start_date' => $this->start_date ?? now(),
                ]);

                // إنشاء الأقساط أولاً
                $monthlyAmount = round($installment->remaining_amount / $plan->months_count, 2);
                $items = [];

                for ($i = 1; $i <= $plan->months_count; $i++) {

                    $item = InstallmentItem::create([
                        'installment_id' => $installment->id,
                        'due_date' => now()->addMonths($i),
                        'amount' => $monthlyAmount,
                        'status' => 'pending',
                        'paypal_order_id' => $order['id'],
                    ]);

                    $items[] = $item;
                }

               $firstItem = $items[0];

                $paypalOrderId = Str::uuid()->toString(); // أو من PayPal service

                $paymentLink = $this->payPalService->createPayment($order, $firstItem);

                $firstItem->update([
                    'payment_link' => $paymentLink,
                    'paypal_token' => $paypalOrderId,
                ]);

                $firstItem->installment->order->user->notify(
                    new InstallmentReminderNotification($firstItem)
                );

                // تسجيل المقدم إذا وجد
                if ($this->down_payment > 0) {
                    Payment::create([
                        'order_id' => $order->id,
                        'amount' => $this->down_payment,
                        'method' => 'cash',
                        'payment_date' => now(),
                    ]);
                }
            }

      
            DB::commit();
            session()->forget('cart');
            $this->cart = [];
            session()->flash('success', 'تم تأكيد الطلب بنجاح.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.scan-product');
    }
}
