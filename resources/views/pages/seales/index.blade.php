@extends('layout.app')

@section('title', ' المبيعات')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

                        <div class="card-header">
                            <h3 class="card-title"> المبيعات</h3>
                            <a href="{{route('sales.create')}}" class="btn btn-success mb-3"> ا المبيعات</a>
                        </div>
                        <div class="card-body">
                            <!-- نموذج إرسال إجازة جماعية -->
                            <form action="#" method="POST">
                                @csrf



                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>


                                            <td>ID</td>
                                            <td>اسم المنتج</td>
                                            <td>الكميه كامله</td>
                                            <td>عدد الوحدات المباعه</td>
                                            <td>اجمالي المبيعات الحاليه </td>
                                            <!-- <td>اجمالي المبيعات المتوقعة </td> -->
                                            <td>مبيعات بدون ربح</td>
                                            <td>اسم الجندي</td>
                                            <td>تاريخ</td>

                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            <tr>

                                                <!--الكميه الكامه current_quantity
                                                        الكميه الحاليه quantity
                                                        cost_price اجمالي السعر من المورد
                                                        price : سعر الوحده
                                                        -->
                                                <td>{{$sale->id}}</td>
                                                <td>{{$sale->product->name}}</td>
                                                <td>{{$sale->product->quantity}}</td>
                                                <td>{{$sale->quantity}}</td>
                                                <td>{{ $sale->total_price }}</td>
                                                <!-- <td>{{$totalExpectedSales = $sale->qئuantity * $sale->product->price }}</td> -->
                                                <td>{{ $sale->total_Total_price_without_profit }}</td>
                                                <td>{{$sale->employee->name }}</td>
                                                <td>{{ $sale->date_of_pay}}</td>

 
                                                 <!-- <td>شهر</td> -->

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary mt-3">إرسال </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts-database')
    <!-- jQuery -->
    <script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- DataTables  & dashboard/Plugins -->
    <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dashboard/dist/js/demo.js') }}"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "lengthChange": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "columnDefs": [
                    { "targets": [3], "visible": true }, // الملاحظات يمكن إخفاءها من colvis
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        $(document).ready(function () {
            // تحديد كل الجنود عند النقر على "اختيار الكل"
            $('#select-all').on('click', function () {
                $('input[name="soldiers[]"]').prop('checked', this.checked);
            });

            // التأكد من أن هناك جنود مختارين قبل إرسال النموذج
            $('form').on('submit', function (e) {
                if ($('input[name="soldiers[]"]:checked').length == 0) {
                    e.preventDefault();
                    Swal.fire('خطأ', 'اذهب الي الصفحة الرائيسيه.', 'error');
                }
            });
        });
    </script>
@endpush