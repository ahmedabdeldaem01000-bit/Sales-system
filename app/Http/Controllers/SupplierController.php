<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $suppliers=Supplier::get();

        return view('pages.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
        ]);
        // dd($data)
;
        Supplier::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'address'=>$data['address'],
        ]);
                    return redirect()->route('supplier.create')->with('success', 'تم اضافه المورد بنجاح');

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
    public function destroy(Request $request)
    {

  $ids = $request->input('supplier'); // نتأكد إن الاسم متطابق مع الفورم

        if ($ids && is_array($ids)) {
            Supplier::whereIn('id', $ids)->delete();
            return redirect()->route('supplier.index')->with('success', 'تم حذف المنتجات المحددة بنجاح');
        }

        return redirect()->route('supplier.index')->with('error', 'لم يتم تحديد منتجات للحذف');

    }

       public function bulkDelete(Request $request)
    {
        $ids = $request->input('supplier'); // نتأكد إن الاسم متطابق مع الفورم

        if ($ids && is_array($ids)) {
            Supplier::whereIn('id', $ids)->delete();
            return redirect()->route('supplier.index')->with('success', 'تم حذف المنتجات المحددة بنجاح');
        }

        return redirect()->route('supplier.index')->with('error', 'لم يتم تحديد منتجات للحذف');
 
    }
}
