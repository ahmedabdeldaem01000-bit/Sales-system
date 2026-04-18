<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'installments')->get();
 
        return view('pages.orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        return view('pages.orders.show' ,compact('orderId'));
    }
}
