@extends('layout.app')

@section('title', 'صفحه المشتريات')

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <a href="{{ route('purchase.create') }}" class="mb-3 btn btn-success">إضافة مشتريات جديد</a>
            </div>

            <div class="card-body">
              <!-- نموذج حذف جماعي -->
              <form action="#" method="POST" id="bulk-delete-form">
                @csrf
                @method('DELETE')

                <button type="submit" class="mb-3 btn btn-danger">حذف مشتريات المحددة</button>

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="select-all"></th>
                      <th>ID</th>
                      <th>اسم المورد</th>
                      <th>اسم المنتج</th>
                      <th>سعر الوحدة</th>
                      <th>الكمية</th>
                      <th>إجمالي التكلفة</th>
                      <th>تاريخ الشراء</th> {{-- أضفنا التاريخ للأهمية --}}
                      <th>الإجراءات</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($items as $item)
                      <tr>
                        <td>
                          <input type="checkbox" name="items[]" value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        {{-- الوصول لاسم المورد عبر علاقة الـ purchase --}}
                        <td>{{ $item->purchase->supplier->name ?? 'غير محدد' }}</td>
                        {{-- الوصول لاسم المنتج --}}
                        <td>{{ $item->product->name ?? 'منتج محذوف' }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->total_price, 2) }}</td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>
                          {{-- رابط التعديل يفضل أن يوجه لتعديل الفاتورة بالكامل أو الصنف --}}
                          <a href="{{ route('purchase.edit',$item->id) }}"
                            class="btn btn-warning btn-sm">تعديل</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
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
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      // تحديد الكل
      $('#select-all').on('click', function () {
        $('input[name="products[]"]').prop('checked', this.checked);
      });

      // التحقق من وجود منتجات محددة
      $('#bulk-delete-form').on('submit', function (e) {
        if ($('input[name="products[]"]:checked').length === 0) {
          e.preventDefault();
          alert('يرجى تحديد منتج واحد على الأقل قبل الحذف.');
        }
      });
    });
  </script>
@endpush