<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // تحميل الموظفين مع العناصر والديون
    $employees = Employee::with(['orderItems', 'debts'])->get();

    foreach ($employees as $employee) {
        // إجمالي المبيعات = price * quantity
        $employee->total_sales = $employee->orderItems->sum(fn($item) => $item->price * $item->quantity);

        // إجمالي المديونية الغير مدفوعة
        $employee->total_debt = $employee->debts
            ->where('payment_status', 'unpaid')
            ->sum(fn($debt) => $debt->price * $debt->quantity);
    }

    return view('pages.emp.index', compact('employees'));
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
    
}
public function sales($id)
{
    $employee = Employee::with(['orders.orderItems.product'])->findOrFail($id);

    return view('pages.emp.show', compact('employee'));
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        // $employee = Employee::with('sales.product')->findOrFail($id);
        // return view('pages.emp.show', compact('employee'));
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
