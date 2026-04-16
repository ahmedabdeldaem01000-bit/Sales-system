@extends('layout.app')

@section('title', ' التقسيط')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title"> التقسيط</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج إرسال إجازة جماعية -->
                        


  <form action="{{ route('installment-delete.bulkDelete') }}" method="POST" id="bulk-delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="mb-3 btn btn-danger">حذف التقسيط المحددة</button>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
   
                                            <th>#</th>
                                            <th>ID</th>
                                            <th> اسم الخطة</th>
                                            <th>عدد الشهور</th>
                                            <th>نسبة الفايده</th>
                                          
                                            <th>actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($installments as $installment)
                                            <tr>
                                                 <td>
                                                    <input type="checkbox" name="installment[]" value="{{ $installment->id }}">
                                                </td>
                                                <td>{{ $installment->id}}</td>
                                                <td>{{ $installment->name  }}</td>
                                                <td>{{ $installment->months_count ?? 'غير معروف'}}</td>

                                                <td>{{ $installment->interest_rate ?? 'غير معروف' }}</td>
                                                
                                                <td>
                                                    <a class="btn btn-success" href="{{ route('installment.edit',$installment->id) }}">update</a>
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
                $('input[name="installment[]"]').prop('checked', this.checked);
            });

            // التأكد من أن هناك جنود مختارين قبل إرسال النموذج
            $('form').on('submit', function (e) {
                if ($('input[name="installment[]"]:checked').length == 0) {
                    e.preventDefault();
                    Swal.fire('خطأ', 'يرجى تحديد مورد واحد على الأقل  .', 'error');
                }
            });
        });
    </script>
@endpush


 