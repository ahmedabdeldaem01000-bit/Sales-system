<div class="container mt-4">
    <h2>Installment Details</h2>

    @if($installment)
        <div class="card">
            <div class="card-body">
                <h5>Installment for Order #{{ $installment->order_id }}</h5>
                <p><strong>Total with Interest:</strong> {{ $installment->total_with_interest }}</p>
                <p><strong>Down Payment:</strong> {{ $installment->down_payment }}</p>
                <p><strong>Remaining Amount:</strong> {{ $installment->remaining_amount }}</p>
            </div>
        </div>

        <div class="mt-3 card">
            <div class="card-header">
                <h5>Installment Items</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Paid Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($installment->installment as $item)
                            <tr>
                                <td>{{ $item->due_date->format('Y-m-d') }}</td>
                             
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->paid_amount }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item == 'paid') badge-success
                                        @elseif($item->status == 'late') badge-danger
                                        @else badge-warning
                                        @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->status != 'paid')
                                        <button class="btn btn-success btn-sm" wire:click="openPaymentModal({{ $item->id }})">
                                            Pay
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>Installment not found.</p>
    @endif

    <a href="{{ route('orders.index') }}" class="mt-3 btn btn-secondary">Back to Orders</a>

    <!-- Payment Modal -->
    @if($showPaymentModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Make Payment</h5>
                        <button type="button" class="close" wire:click="closePaymentModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="pay">
                            <div class="form-group">
                                <label for="paymentAmount">Payment Amount</label>
                                <input type="number" step="0.01" class="form-control" id="paymentAmount" wire:model="paymentAmount" required>
                                @error('paymentAmount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    @if (session()->has('success'))
        <div class="mt-3 alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="mt-3 alert alert-danger">{{ session('error') }}</div>
    @endif
</div>