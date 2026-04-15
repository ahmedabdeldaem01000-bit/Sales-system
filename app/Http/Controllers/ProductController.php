<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        return view('pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::get();
        $suppliers = Supplier::get();

        return view('pages.product.create',compact('employees','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
            if (Product::where('barcode', $request->barcode)->exists()) {
        return back()->with('error', 'المنتج بهذا الباركود موجود بالفعل.');
    }
         
        // حساب التكلفة الكلية
        $total_cost = $validated['price_unit'] * $validated['total_quantity'];
    
        // إنشاء المنتج
        Product::create([
            'name'             => $validated['name'],
            'barcode'          => $validated['barcode'],
            'price'            => $validated['total_price'],  // سعر البيع
            'quantity'         => $validated['total_quantity'], // الكمية
            'cost_price'       => $validated['price_unit'],     // سعر الشراء
            
            'created_at'       => $validated['date_of_pay'],
            'total_cost'       => $total_cost, 
        ]);
    
       
        return redirect()->route('product.index')->with('success', 'تم إضافة المنتج بنجاح');

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
    
    $product = Product::findOrFail($id);
    $employees = Employee::all();
    $suppliers = Supplier::all();
 
    return view('pages.product.edit', compact('product', 'employees', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
  
public function update(Request $request, string $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'barcode' => 'required|string|unique:products,barcode,' . $id,
        'price' => 'required|numeric',
        'total_quantity' => 'required|integer',
        'price_unit' => 'required|numeric',
       
        'date_of_pay' => 'required|date',
    ]);

    $product->update([
        'name' => $request->name,
        'barcode' => $request->barcode,
        'price' => $request->price,
        'quantity' => $request->total_quantity,
        'cost_price' => $request->price_unit,
        
        'created_at' => $request->date_of_pay,
        'total_cost' => $request->price_unit * $request->total_quantity,
    ]);

    return redirect()->route('product.index')->with('success', 'تم تعديل المنتج بنجاح');
}

 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('products'); // نتأكد إن الاسم متطابق مع الفورم

        if ($ids && is_array($ids)) {
            Product::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'تم حذف المنتجات المحددة بنجاح');
        }

        return redirect()->back()->with('error', 'لم يتم تحديد منتجات للحذف');
 
    }
 
}
