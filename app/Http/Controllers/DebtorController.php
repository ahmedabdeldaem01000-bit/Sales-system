<?php

namespace App\Http\Controllers;

 
use App\Models\Debtor;
use App\Models\Employee;
use Illuminate\Http\Request;

class DebtorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debtors= Debtor::get();
    
       return view('pages.debtor.index',compact('debtors'));    
    }

 
public function markAsPaid($id)
{
    $debt = Debtor::findOrFail($id); // ✅ استخدم نفس الموديل المستخدم في العرض
    $debt->payment_status = 'paid';
    $debt->save();
    return redirect()->back()->with('success', 'تم تسديد المديونية.');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees= Employee::get();
        return view('pages.debtor.create',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'user' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
        ]);
    
        try {
            Debtor::create([
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'user' => $request->user,
                'employee_id' => $request->employee_id,
                'date' => $request->date,
            ]);
    
            return redirect()->back()->with('success', 'تمت الإضافة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
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
