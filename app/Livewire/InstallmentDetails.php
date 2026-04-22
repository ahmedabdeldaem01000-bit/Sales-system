<?php

namespace App\Livewire;

use App\Models\Installment;
use App\Models\InstallmentItem;
use App\Models\Payment;
use Livewire\Component;

class InstallmentDetails extends Component
{
    public $installmentId;
    public $installment;
    public $showPaymentModal = false;
    public $selectedItemId;
    public $paymentAmount;

    public function mount($installmentId)
    {
        $this->installmentId = $installmentId;
        $this->loadInstallment();
    }

    public function loadInstallment()
    {
        $this->installment = Installment::with('installment', 'order')->find($this->installmentId);
    }

    public function openPaymentModal($itemId)
    {
        $this->selectedItemId = $itemId;
        $this->paymentAmount = null;
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedItemId = null;
        $this->paymentAmount = null;
    }

    public function pay()
    {
        $this->validate([
            'paymentAmount' => 'required|numeric|min:0.01',
        ]);

        $item = InstallmentItem::find($this->selectedItemId);
        if (!$item) {
            session()->flash('error', 'Item not found.');
            return;
        }

        $remaining = $item->amount - $item->paid_amount;
        if ($this->paymentAmount > $remaining) {
            session()->flash('error', 'Payment amount exceeds remaining amount.');
            return;
        }

        // Create payment
        Payment::create([
            'order_id' => $this->installment->order_id,
            'installment_item_id' => $this->selectedItemId,
            'amount' => $this->paymentAmount,
            'method' => 'cash', // or whatever
            'payment_date' => now(),
        ]);

        
        // Update item paid_amount
        $item->paid_amount += $this->paymentAmount;
        $item->save();

        // Update status
        if ($item->paid_amount >= $item->amount) {
            $item->status = 'paid';
        } elseif ($item->due_date < now()->toDateString()) {
            $item->status = 'late';
        } else {
            $item->status = 'pending';
        }
        $item->save();

        // Update installment remaining
        $this->installment->remaining_amount -= $this->paymentAmount;
        $this->installment->save();

        // Update order paid_amount
        $order = $this->installment->order;
        $order->paid_amount += $this->paymentAmount;
        $order->save();

        $this->closePaymentModal();
        $this->loadInstallment();
        session()->flash('success', 'Payment recorded successfully.');
    }

    public function render()
    {
        return view('livewire.installment-details');
    }
}