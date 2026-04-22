@extends('layout.app')

@section('title', 'الموظفين')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="text-white card-header bg-primary">
                <h3 class="card-title">قائمة الموظفين </h3>
            </div>
            <div class="card-body">
                  <form action="{{ route('employee.bulkDelete') }}" method="POST" id="bulk-delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="mb-3 btn btn-danger">حذف الموظفين المحددة</button>
                                   <table class="table text-center table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>اسم الموظف</th>
                            <th>التلفون</th>
                            <th>العنوان</th>
                            <th>الايميل</th>
                            <th>الصلاحيه</th>
                            <th>اجراء</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                 <td>
                                                    <input type="checkbox" name="employees[]" value="{{ $employee->id }}">
                                                </td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->role }}</td>

                                <td>
                                    <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-info btn-sm">
                                        تعديل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                                </form>
             
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // تحديد الكل
            $('#select-all').on('click', function () {
                $('input[name="employees[]"]').prop('checked', this.checked);
            });

            // التحقق من وجود منتجات محددة
            $('#bulk-delete-form').on('submit', function (e) {
                if ($('input[name="employees[]"]:checked').length === 0) {
                    e.preventDefault();
                    alert('يرجى تحديد موظف واحد على الأقل قبل الحذف.');
                }
            });
        });
    </script>
@endpush