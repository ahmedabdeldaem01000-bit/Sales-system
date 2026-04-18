@section('title', 'orders')
<div class="container mt-4">
    <h2>Orders List</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Total</th>
                        <th>Payment Type</th>
                        <th>Paid Amount</th>
                        <th>Remaining Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ ucfirst($order->payment_type) }}</td>
                            <td>{{ $order->paid_amount }}</td>
                            <td>
                                @if($order->payment_type == 'cash')
                                    {{ $order->total - $order->paid_amount }}
                                @else
                                    {{ $order->installments->first()->remaining_amount ?? 0 }}
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" wire:click="viewDetails({{ $order->id }})">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


