<?php

namespace App\Http\Controllers;

use App\Models\InstallmentPlan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductsEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        $installments = InstallmentPlan::all();
        $users = User::all();
        return view('pages.employee-dashboard.dashboard', compact('product', 'users','installments'));
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
    public function show(string $barcode)
    {
        $product = Product::where('barcode', $barcode)->get();



        return view('pages.employee-dashboard.dashboard', compact('product'));

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
