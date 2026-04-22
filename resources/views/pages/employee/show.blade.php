@extends('layout.app')

@section('title', 'مبيعات الموظف')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h3 class="mb-4">مبيعات الموظف: {{ $employee->name }}</h3>

        @forelse($employee->orders as $order)
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0 card-title">
                        <i class="fas fa-receipt"></i>
                        رقم الطلب: {{ $order->id }}
                    </h5>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>

                <div class="p-0 card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 text-center table-bordered table-striped">
                            <thead class="text-white bg-secondary">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر الفردي</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'منتج غير معروف' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price, 2) }} ج.م</td>
                                        <td>{{ number_format($item->total, 2) }} ج.م</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 text-right bg-light">
                        <strong>إجمالي الطلب:</strong>
                        {{ number_format($order->orderItems->sum('total'), 2) }} ج.م
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">لا توجد مبيعات لهذا الموظف حتى الآن.</div>
        @endforelse
    </div>
</section>
@endsection
