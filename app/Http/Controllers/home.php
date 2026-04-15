<?php

namespace App\Http\Controllers;

use App\Models\Debtor;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;

class home extends Controller
{
    public function index(){
        return view('pages.admin.dashboard', [
            'totalUnpaid' => Debtor::where('payment_status', 'unpaid')->sum(DB::raw('price * quantity')),
            'salesCount' => Order::count(),
            'customersCount' => Debtor::distinct('customer_name')->count('customer_name'),
        ]);
   
    }
}
