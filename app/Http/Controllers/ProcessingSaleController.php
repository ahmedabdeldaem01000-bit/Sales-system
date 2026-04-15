<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
 use App\Models\ProcessingSale;
use App\Models\Product;
use Illuminate\Http\Request;

class ProcessingSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
$report = ProcessingSale::paginate(10); 
return view('pages.admin.sales-report.index', compact('report'));

    }
public function processSales()
{
    // امسح الجدول القديم لو عايز تحدثه بالكامل
    ProcessingSale::truncate();

    $products = Product::all();
 foreach ($products as $product) {
    $soldData = OrderItem::where('product_id', $product->id)
        ->selectRaw('SUM(quantity) as total_quantity, SUM(quantity * price) as total_sales')
        ->first();

    if (!$soldData->total_quantity || $soldData->total_quantity == 0) {
        continue; // تجاهل المنتج اللي مش متباع
    }

    ProcessingSale::create([
        'product_name'         => $product->name,
        'total_quantity_sold'  => $soldData->total_quantity,
        'total_sales'          => $soldData->total_sales,
        'current_stock'        => $product->quantity,
       'original_stock' => ($soldData->total_quantity ?? 0) + $product->quantity
    ]);
}

    return redirect()->back()->with('success', 'تم إنشاء تقرير المبيعات بنجاح ✅');
}
    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
