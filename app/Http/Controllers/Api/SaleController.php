<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
                return Product::get();

    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id'                   => 'required|exists:employees,id',
            'product_id'                    => 'required|exists:products,id',
            'quantity'                      => 'required|integer|min:1',
            'price_unit'                    => 'required|numeric',
            'price_profit'                  => 'required|numeric',
            'date_of_pay'                   => 'required|date',
            'total_price'                   => 'required|numeric',
            'total_Total_price_without_profit' => 'required|numeric',
        ]);

        $sale = Sale::create($data);
        return response()->json($sale, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
