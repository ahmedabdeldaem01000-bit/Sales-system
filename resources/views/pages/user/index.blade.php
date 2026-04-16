@extends('layout.app')

@section('title', ' العملاء')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title"> العملاء</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج إرسال إجازة جماعية -->
                        


  <form action="{{ route('user.bulkDelete') }}" method="POST" id="bulk-delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="mb-3 btn btn-danger">حذف المستخدمين </button>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
   
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>اسم العميل</th>
                                            <th>الايميل</th>
                                            <th>الهاتف</th>
                                            <th>العنوان</th>
                                            <th>actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                 <td>
                                                    <input type="checkbox" name="user[]" value="{{ $user->id }}">
                                                </td>
                                                <td>{{ $user->id}}</td>
                                                <td>{{ $user->name  }}</td>
                                                <td>{{ $user->email ?? 'غير معروف'}}</td>
                                                <td>{{ $user->phone ?? 'غير معروف' }}</td>
                                                <td>{{ $user->address ?? 'غير معروف' }}</td>
                                                <td>
                                                    <a class="btn btn-success" href="{{ route('user.edit',$user->id) }}">update</a>
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
                $('input[name="user[]"]').prop('checked', this.checked);
            });

            // التأكد من أن هناك جنود مختارين قبل إرسال النموذج
            $('form').on('submit', function (e) {
                if ($('input[name="user[]"]:checked').length == 0) {
                    e.preventDefault();
                    Swal.fire('خطأ', 'يرجى تحديد مستخدم واحد على الأقل  .', 'error');
                }
            });
        });
    </script>
@endpush


