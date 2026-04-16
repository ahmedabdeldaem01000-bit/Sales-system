<?php

namespace App\Http\Controllers;

 use App\Models\InstallmentPlan;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $installments = InstallmentPlan::get();
        return view('pages.installment.index', compact('installments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.installment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'months_count' => 'required',
            'interest_rate' => 'required',
        ]);
        InstallmentPlan::create([
            'name' => $data['name'],
            'months_count' => $data['months_count'],
            'interest_rate' => $data['interest_rate'],
        ]);
        return redirect()->route('installment.create')->with('success', 'تم انشاء الخطة بنجاح');
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
        $installment=InstallmentPlan::findOrFail($id);
        return view('pages.installment.edit',compact('installment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $instalment= InstallmentPlan::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'months_count' => 'required',
            'interest_rate' => 'required',
        ]);

        $instalment->update([
               'name' => $data['name'],
            'months_count' => $data['months_count'],
            'interest_rate' => $data['interest_rate'],
        ]);
           return redirect()->route('installment.index')->with('success', 'تم التعديل  بنجاح');
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
        $ids = $request->input('installment'); // نتأكد إن الاسم متطابق مع الفورم

        if ($ids && is_array($ids)) {
            InstallmentPlan::whereIn('id', $ids)->delete();
            return redirect()->route('installment.index')->with('success', 'تم حذف المنتجات المحددة بنجاح');
        }

        return redirect()->route('installment.index')->with('error', 'لم يتم تحديد منتجات للحذف');

    }
}
