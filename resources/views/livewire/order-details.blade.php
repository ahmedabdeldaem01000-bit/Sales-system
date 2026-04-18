<div class="container mt-4">
    <h2>Order Details</h2>

    @if($order)
        <div class="card">
            <div class="card-body">
                <h5>Customer: {{ $order->user->name ?? 'N/A' }}</h5>
                <p><strong>Total:</strong> {{ $order->total }}</p>
                <p><strong>Payment Type:</strong> {{ ucfirst($order->payment_type) }}</p>
                <p><strong>Paid Amount:</strong> {{ $order->paid_amount }}</p>

                @if($order->payment_type == 'installment' && $order->installments->count() > 0)
                    <p><strong>Installment Plan:</strong> {{ $order->installments->first()->plan->name }}</p>
                    <p><strong>Down Payment:</strong> {{ $order->installments->first()->down_payment }}</p>
                    <p><strong>Remaining:</strong> {{ $order->installments->first()->remaining_amount }}</p>
                    <button class="btn btn-info" wire:click="viewInstallment({{ $order->installments->first()->id }})">
                        View Installment Details
                    </button>
                @endif
            </div>
        </div>

        <div class="mt-3 card">
            <div class="card-header">
                <h5>Products</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>Order not found.</p>
    @endif

    <a href="{{ route('orders.index') }}" class="mt-3 btn btn-secondary">Back to Orders</a>
</div>