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
        // $employees = Employee::with(['orderItems', 'debts'])->get();

        // foreach ($employees as $employee) {

        //     $employee->total_sales = $employee->orderItems->sum(fn($item) => $item->price * $item->quantity);

        //     $employee->total_debt = $employee->debts
        //         ->where('payment_status', 'unpaid')
        //         ->sum(fn($debt) => $debt->price * $debt->quantity);
        // }

        // return view('pages.emp.index', compact('employees'));

        $employees = Employee::get();

        return view('pages.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);
        return redirect()->route('employee.create')->with('success','Employee Created successfully');
    }

    public function sales($id)
    {
        $employee = Employee::with(['orders.orderItems.product'])->findOrFail($id);

        return view('pages.employee.show', compact('employee'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $employee = Employee::findOrFail($id);
        return view('pages.employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
            $employee = Employee::findOrFail($id);
        return view('pages.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee=Employee::findOrFail($id);
           $data = $request->validate([
            'name' => 'required',
            'email' => 'required',  
            'phone' => 'required',
            'address' => 'required',
        ]);

        $employee->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);
        return redirect()->route('employee.edit',$id)->with('success','employee Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
            $ids = $request->input('employees'); // نتأكد إن الاسم متطابق مع الفورم

        if ($ids && is_array($ids)) {
            Employee::whereIn('id', $ids)->delete();
            return redirect()->route('employee.index')->with('success', 'تم حذف الموظف  بنجاح');
        }

        return redirect()->route('employee.index')->with('error', 'لم يتم تحديد موظف للحذف');

    }
       public function bulkDelete(Request $request)
    {
            $ids = $request->input('employees'); // نتأكد إن الاسم متطابق مع الفورم
            // dd($ids);

        if ($ids && is_array($ids)) {
            Employee::whereIn('id', $ids)->delete();
            return redirect()->route('employee.index')->with('success', 'تم حذف الموظف  بنجاح');
        }

        return redirect()->route('employee.index')->with('error', 'لم يتم تحديد موظف للحذف');

    }
}
