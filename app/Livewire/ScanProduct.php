<?php

namespace App\Livewire;


use App\Models\Debtor;
use DB;
use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
class ScanProduct extends Component
{
    public $barcode;
    public $product;
    public $quantity = 1;
    public $cart = [];
    public $is_debtor = false;
    public ?string $customer_name = '';

    public function mount()
    {
        $this->cart = session('cart', []);
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

        if (empty($cart)) {
            session()->flash('error', 'السلة فارغة.');
            return;
        }
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        // ✅ إدخال في جدول order_items
        $order = Order::create([
            'total' => $total,

            'employee_id' => auth()->id(),
        ]);
        foreach ($cart as $item) {
            $product = Product::find($item['id']);

            if (!$product || $item['quantity'] > $product->quantity) {
                session()->flash('error', 'الكمية غير متوفرة للمنتج: ' . $item['name']);
                return;
            }




            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'employee_id' => auth()->id(),
            ]);
            // خصم الكمية من المخزون
            $product->decrement('quantity', $item['quantity']);

            $product->save();
            if ($this->is_debtor) {
                if (!$this->customer_name) {
                    session()->flash('error', 'من فضلك أدخل اسم العميل.');
                    return;
                }
                $total = $item['price'] * $item['quantity'];

                Debtor::create([
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'customer_name' => $this->customer_name,
                    'user' => auth()->user()->name ?? 'guest',
                    'employee_id' => auth()->id(),
                    'date' => now(),
                    'payment_status' => 'unpaid',
                    'total' => $total,
                ]);
            }
        }

        // تفريغ السلة بعد الإضافة

        session()->forget('cart');
        $this->cart = [];
        $this->is_debtor = false;
        $this->customer_name = null;
      
        session()->flash('success', 'تم تأكيد الطلب بنجاح.');

    }


    public function render()
    {
        return view('livewire.scan-product');
    }
}
