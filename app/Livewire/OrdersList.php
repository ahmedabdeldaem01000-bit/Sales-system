<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrdersList extends Component
{
    public function render()
    {
        $orders = Order::with('user', 'installments')->get();
 
        return view('livewire.orders-list',compact('orders'));
    }

    public function viewDetails($orderId)
    {
        return redirect()->route('order.show', $orderId);
    }
}