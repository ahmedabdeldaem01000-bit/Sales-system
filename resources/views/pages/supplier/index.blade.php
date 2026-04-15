@extends('layout.app')

@section('title', ' الموردين')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title"> الموردين</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج إرسال إجازة جماعية -->
                        


  <form action="{{ route('supplier.bulkDelete') }}" method="POST" id="bulk-delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="mb-3 btn btn-danger">حذف المنتجات المحددة</button>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
   
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>اسم المورد</th>
                                            <th>الايميل</th>
                                            <th>الهاتف</th>
                                            <th>العنوان</th>
                                            <th>actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                 <td>
                                                    <input type="checkbox" name="supplier[]" value="{{ $supplier->id }}">
                                                </td>
                                                <td>{{ $supplier->id}}</td>
                                                <td>{{ $supplier->name  }}</td>
                                                <td>{{ $supplier->email ?? 'غير معروف'}}</td>

                                                <td>{{ $supplier->phone ?? 'غير معروف' }}</td>
                                                <td>{{ $supplier->address ?? 'غير معروف' }}</td>
                                                <td>
                                                    <a class="btn btn-success" href="{{ route('supplier.edit',$supplier->id) }}">update</a>
                                                </td>
                                                <!-- التحقق إذا كان employee موجود -->




                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="mt-3 btn btn-primary">إرسال </button>
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
                $('input[name="supplier[]"]').prop('checked', this.checked);
            });

            // التأكد من أن هناك جنود مختارين قبل إرسال النموذج
            $('form').on('submit', function (e) {
                if ($('input[name="supplier[]"]:checked').length == 0) {
                    e.preventDefault();
                    Swal.fire('خطأ', 'يرجى تحديد مورد واحد على الأقل  .', 'error');
                }
            });
        });
    </script>
@endpush




<!-- ////////////////////////////////////////////////////////// -->