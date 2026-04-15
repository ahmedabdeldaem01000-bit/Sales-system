@extends('layout.app')
@section('title', 'تقرير المديونية')

@section('content')
 
<table class="table table-bordered">
    <thead>
        <tr>
            <th>اسم العميل</th>
            <th>اسم المنتج</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>الإجمالي</th>
            <th>الموظف</th>
            <th>التاريخ</th>
        </tr>
    </thead>
    <tbody>
 @foreach($debtors as $d)
    @if($d->payment_status === 'unpaid') {{-- فقط الطلبات الغير مدفوعة --}}
        <tr>
            <td>{{ $d->customer_name }}</td>
            <td>{{ $d->name }}</td>
            <td>{{ $d->price }}</td>
            <td>{{ $d->quantity }}</td>
            <td>{{ $d->price * $d->quantity }}</td>
            <td>{{ $d->employee->name ?? '-' }}</td>
            <td>{{ $d->date }}</td>
            <td>
                {{-- زر تحويل الحالة إلى paid --}}
       <form action="{{ route('debt.markAsPaid', $d->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit">تسديد</button>
                </form>
            </td>
        </tr>
    @endif
@endforeach

    </tbody>
</table>
@endsection
