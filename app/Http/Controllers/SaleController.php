<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use DB;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with([ 'employee'])->get();
        $products = Product::with('sales')->get();
        return view('pages.seales.index', compact('sales'));

     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $products = Product::with(['employee','supplier'])->get(); 
        $Employees = Employee::all();
        $Suppliers = Supplier::all();
        $Products = Product::all();
        return view('pages.seales.create' ,compact('Employees','Suppliers','Products'));
    }

    /**
     * Store a newly created resource in storage.
     */
 
    
     public function store(Request $request)
     {
         // التحقق من صحة البيانات المدخلة
         $data = $request->validate([
             'product_id'     => 'required|exists:products,id',
             'employee_id'    => 'required|exists:employees,id',
             'price_unit'     => 'required|numeric',
             'price_profit'   => 'required|numeric',
             'quantity'       => 'required|integer|min:1',
             'date_of_pay'    => 'required|date',
         ]);
     
         // جلب المنتج من قاعدة البيانات
         $product = Product::findOrFail($data['product_id']);
     
         // تحقق من الكمية المتاحة قبل البيع
         if ($data['quantity'] > $product->quantity) {
             // إذا كانت الكمية المطلوبة أكبر من المتوفرة
             return redirect()->route('sales.index')->with('error', 'الكمية المطلوبة أكبر من الكمية المتوفرة في المخزون');
         }
     
         // بدء المعاملة
         DB::beginTransaction();
     
         try {
            // حساب القيم
            $totalPrice = $data['quantity'] * $data['price_profit'];
            $total_Total_price_without_profit = $data['quantity'] * $data['price_unit'];
        
            // إنشاء السجل في جدول المبيعات
            Sale::create([
                'product_id'   => $product->id,
                'employee_id'  => $data['employee_id'],
                'price_unit'   => $data['price_unit'],
                'quantity'     => $data['quantity'],
                'price_profit' => $data['price_profit'],
                'date_of_pay'  => $data['date_of_pay'],
                'total_price'  => $totalPrice,
                'total_Total_price_without_profit' => $total_Total_price_without_profit,
            ]);
        
            // خصم الكمية من المخزون
            $product->decrement('quantity', $data['quantity']);
        
            // زيادة الكمية المباعة
            $product->increment('sold_quantity', $data['quantity']);
        
            // ✅ تحديث اجمالي المبيعات للموظف
            $employee = Employee::find($data['employee_id']);
            $employee->prg += $totalPrice;
            $employee->save();
        
            // إنهاء المعاملة
            DB::commit();
        
            return redirect()->route('sales.index')->with('success', 'تم بيع ' . $data['quantity'] . ' وحدة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sales.index')->with('error', 'حدث خطأ أثناء معالجة عملية البيع');
        }
        
     }
     

     
     

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
