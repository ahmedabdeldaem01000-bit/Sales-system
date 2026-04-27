<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {

        $items = PurchaseItem::with(['purchase.supplier', 'product', 'purchase.employee'])->get();

        return view('pages.purchase.index', compact('items'));
    }

    public function create()
    {
        $products = Product::get();
        $suppliers = Supplier::get();
        return view('pages.purchase.create', compact('products', 'suppliers'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_price' => 'required|numeric',
            'items.*.total_quantity' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // 1. إنشاء الفاتورة الأساسية
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'employee_id' => auth()->id(),
                'total_price' => $request->grand_total,
            ]);
            

            // 2. تكرار العملية لكل منتج في المصفوفة
            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['total_quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['unit_price'] * $item['total_quantity'],
                ]);

                // 3. تحديث المخزن لكل منتج
                $product = Product::findOrFail($item['product_id']);
                $product->increment('quantity', $item['total_quantity']);
            }

            DB::commit();
            return redirect()->back()->with('success', 'تم تسجيل الفاتورة بنجاح وتحديث المخزن.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'خطأ: ' . $e->getMessage());
        }
    }





    public function edit(string $id)
    {

        // جلب سطر المشتريات مع العلاقات
        $item = PurchaseItem::with(['purchase.supplier', 'product'])->findOrFail($id);

        // جلب المنتجات والموردين لعرضهم في القوائم المنسدلة (Dropdowns)
        $products = Product::all();
        $suppliers = Supplier::all();
 
        return view('pages.purchase.edit', compact('item', 'products', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $item = PurchaseItem::findOrFail($id);
        $product = Product::findOrFail($item->product_id);

        $request->validate([
            'unit_price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            // 1. استرجاع المخزن للحالة السابقة (طرح الكمية القديمة)
            $product->decrement('quantity', $item->quantity);

            // 2. تحديث سطر المشتريات
            $item->update([
                'unit_price' => $request->unit_price,
                'quantity' => $request->quantity,
                'total_price' => $request->unit_price * $request->quantity,
            ]);

            // 3. إضافة الكمية الجديدة للمخزن
            $product->increment('quantity', $request->quantity);

            // 4. تحديث إجمالي الفاتورة الكبيرة (اختياري لو أردت الدقة)
            $purchase = $item->purchase;
            $newTotal = $purchase->items()->sum('total_price');
            $purchase->update(['total_price' => $newTotal]);

            DB::commit();
            return redirect()->route('purchase')->with('success', 'تم تعديل المشتريات وتحديث المخزن');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'خطأ: ' . $e->getMessage());
        }
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
