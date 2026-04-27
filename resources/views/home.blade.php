@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">لوحة التحكم</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- INFO BOXES -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="flex flex-row flex-wrap items-center justify-between small-box bg-success">
                        <div class="inner">
                            <h4>{{ $totalRevenue }} ج.م</h4>
                            <p>إجمالي الإيرادات</p>
                        </div>
                        <div class="icon h-[6rem]">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="flex flex-row flex-wrap items-center justify-between small-box bg-info">
                        <div class="inner">
                            <h4>{{ $salesCount }}</h4>
                            <p>عدد المبيعات</p>
                        </div>
                        <div class="icon  h-[6rem]">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="flex flex-row flex-wrap items-center justify-between small-box bg-warning">
                        <div class="inner">
                            <h4>{{ $customersCount }}</h4>
                            <p>عدد العملاء</p>
                        </div>
                        <div class="icon h-[6rem]">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="flex flex-row flex-wrap items-center justify-between small-box bg-danger">
                        <div class="inner ">
                            <h4>{{ number_format($totalUnpaid, 2) }} ج.م</h4>
                            <p>إجمالي المديونية</p>
                        </div>
                        <div class="icon h-[6rem]">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CHARTS ROW -->
            <div class="gap-6 row">


                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">تقرير السنة الحالية</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="height: 300px;"></canvas>
                    </div>
                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">إحصائيات الطلبات والإيرادات</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="lineChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- TABLES ROW -->
            <div class="row">
                <!-- TABLE 1: Users with Orders -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">العملاء الأكثر شراءً</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>اسم العميل</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>عدد الطلبات</th>
                                        <th>إجمالي المشتريات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($usersWithOrders as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><span class="badge badge-primary">{{ $user->total_orders }}</span></td>
                                            <td>{{ number_format($user->total_spent, 2) }} ج.م</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">لا توجد بيانات متاحة</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TABLE 2: Top Selling Products -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">أعلى المنتجات مبيعاً (التفاصيل)</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>اسم المنتج</th>
                                        <th>عدد الطلبات</th>
                                        <th>الكمية المباعة</th>
                                        <th>السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topProducts as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                                            <td><span class="badge badge-info">{{ $item->order_count }}</span></td>
                                            <td>{{ $item->total_quantity }} وحدة</td>
                                            <td>{{ number_format($item->product->price ?? 0, 2) }} ج.م</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">لا توجد بيانات متاحة</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts-database')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <!-- Flot Charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.categories.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.min.js"></script>
    <script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('dashboard/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dashboard/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('dashboard/dist/js/demo.js')}}"></script>
    <script>
        // البيانات اللي جاية من الـ Controller
        const labels = {!! json_encode($labels) !!};
        const dataValues = {!! json_encode($values) !!};

        // إعداد التشارت
        new Chart($('#revenueChart').get(0).getContext('2d'), {
            type: 'line', // أو 'bar'
            data: {
                labels: labels,
                datasets: [{
                    label: 'العدد',
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: '#28a745',
                    data: dataValues
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
            }
        });


   
      
 
$(function () {

    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')

    var lineChartData = {
        labels: @json($months), // 👈 الشهور
        datasets: [
            {
                label: 'عدد الطلبات',
                data: @json($counts), // 👈 عدد الطلبات
                borderColor: '#007BFF',
                backgroundColor: 'rgba(0,123,255,0.1)',
                fill: false,
                tension: 0.4
            },
            {
                label: 'الإيرادات',
                data: @json($revenues), // 👈 الإيرادات
                borderColor: '#28a745',
                backgroundColor: 'rgba(40,167,69,0.1)',
                fill: false,
                tension: 0.4
            }
        ]
    }

    var lineChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false
        },
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true
            }
        }
    }

    new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    });

});
 

    
    </script>

@endpush