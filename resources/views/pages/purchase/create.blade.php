@extends('layout.app')

@section('title', 'صفحه اضافه مشتريات')

@section('content')
  <section class="content">
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    <div class="container-fluid">
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">صفحه اضافه مشتريات</h3>
        </div>
        <form action="{{ route('purchase.store') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <label>اسم المورد</label>
                <select name="supplier_id" class="mb-4 form-control">
                  @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <table class="table table-bordered" id="items-table">
              <thead>
                <tr>
                  <th>المنتج</th>
                  <th>سعر الوحدة</th>
                  <th>الكمية</th>
                  <th>الإجمالي</th>
                  <th><button type="button" class="btn btn-success btn-sm" id="add-row">+</button></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select name="items[0][product_id]" class="form-control">
                      @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td><input type="number" name="items[0][unit_price]" class="form-control unit-price" step="0.01"></td>
                  <td><input type="number" name="items[0][total_quantity]" class="form-control quantity"></td>
                  <td><input type="text" name="items[0][total_price]" class="form-control row-total" readonly></td>
                  <td></td>
                </tr>
              </tbody>
            </table>

            <div class="mt-3 row">
              <div class="col-md-4 offset-md-8">
                <label>إجمالي الفاتورة النهائي</label>
                <input type="text" id="grand-total" name="grand_total" class="form-control" readonly>
              </div>
            </div>
          </div>
          <button type="submit" class="mb-4 ml-4 btn btn-primary">حفظ الفاتورة</button>
        </form>

        <!-- /.card-body -->
      </div>
    </div>
  </section>
@endsection

@push('scripts-database')
  <script>
    const priceInput = document.getElementById('unit_price');
    const qtyInput = document.getElementById('quantity');
    const totalInput = document.getElementById('total_price');

    function calculateTotal() {
      const price = parseFloat(priceInput.value) || 0;
      const qty = parseFloat(qtyInput.value) || 0;
      totalInput.value = (price * qty).toFixed(2);
    }

    priceInput.addEventListener('input', calculateTotal);
    qtyInput.addEventListener('input', calculateTotal);
  </script>



<script>
    let rowIndex = 1;
    document.getElementById('add-row').addEventListener('click', function() {
        let table = document.getElementById('items-table').getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();
        newRow.innerHTML = `
            <td>
                <select name="items[${rowIndex}][product_id]" class="form-control">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${rowIndex}][unit_price]" class="form-control unit-price" step="0.01"></td>
            <td><input type="number" name="items[${rowIndex}][total_quantity]" class="form-control quantity"></td>
            <td><input type="text" name="items[${rowIndex}][total_price]" class="form-control row-total" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">x</button></td>
        `;
        rowIndex++;
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('unit-price') || e.target.classList.contains('quantity')) {
            let row = e.target.closest('tr');
            let price = row.querySelector('.unit-price').value || 0;
            let qty = row.querySelector('.quantity').value || 0;
            row.querySelector('.row-total').value = (price * qty).toFixed(2);
            
            calculateGrandTotal();
        }
    });

    function calculateGrandTotal() {
        let totals = document.querySelectorAll('.row-total');
        let sum = 0;
        totals.forEach(t => sum += parseFloat(t.value || 0));
        document.getElementById('grand-total').value = sum.toFixed(2);
    }
</script>
@endpush