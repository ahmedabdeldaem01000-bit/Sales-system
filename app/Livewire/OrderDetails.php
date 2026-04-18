<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderDetails extends Component
{
    public $orderId;
    public $order;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->loadOrder();
    }

    public function loadOrder()
    {
        $this->order = Order::with('user', 'items.product', 'installments.plan')->find($this->orderId);
    }

    public function viewInstallment($installmentId)
    {
        return redirect()->route('installment.show', $installmentId);
    }

    public function render()
    {
        return view('livewire.order-details');
    }
}