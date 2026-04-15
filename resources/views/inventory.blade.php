<style>
    @media print {
        .no-print { display: none; }
        body { direction: rtl; font-family: 'Arial', sans-serif; }
    }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: right; }
    .header { text-align: center; margin-bottom: 30px; }
</style>

<div class="header">
    <h1>فاتورة مبيعات</h1>
    <p>رقم الطلب: #{{ $order->id }}</p>
    <p>التاريخ: {{ $order->created_at->format('Y-m-d H:i') }}</p>
    <p>الموظف: {{ $order->employee->name }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>المنتج</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>الإجمالي</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ number_format($item->price, 2) }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>الإجمالي الكلي: {{ number_format($order->total, 2) }} جنيه</h3>

<button onclick="window.print()" class="no-print">اطبع الآن</button>