@extends('layout.app')

@section('title', 'تقرير مبيعات الموظفين')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="text-white card-header bg-primary">
                <h3 class="card-title">قائمة الموظفين ومبيعاتهم</h3>
            </div>
            <div class="card-body">
                <table class="table text-center table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>اسم الموظف</th>
                            <th>إجمالي المبيعات</th>
                            <th>إجمالي المديونية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ number_format($employee->total_sales, 2) }} ج.م</td>
                                <td>{{ number_format($employee->total_debt, 2) }} ج.م</td>
                                <td>
                                    <a href="{{ route('employees.sales', $employee->id) }}" class="btn btn-info btn-sm">
                                        عرض التفاصيل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
