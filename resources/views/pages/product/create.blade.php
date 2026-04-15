@extends('layout.app')

@section('title', 'اضافه منتج')

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
      <h3 class="card-title">اضافه منتج</h3>
      </div>
      <form action="{{ route('product.store') }}" method="POST">
      @csrf

      <div class="card-body">
     <div class="row">
     <div class="col-4">
          <label for="exampleInputFile">الاسم</label>
          <input type="text" class="form-control" name="name" placeholder="ادخل اسم المنتج">
          @error('name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
        <div class="col-4">
    <label for="barcode">الباركود</label>
    <input type="text" name="barcode" id="barcode-input" autofocus class="form-control" placeholder="امسح الباركود هنا">
    @error('barcode')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
     <div class="col-4">
          <label for="exampleInputFile">السعر بي الربح</label>
          <input type="text" class="form-control" name="total_price" placeholder="ادخل اجمالي السعر">
          @error('total_price')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
     <div class="col-4">
          <label for="exampleInputFile">اجمال الكميه</label>
          <input type="text" class="form-control" name="total_quantity" placeholder="ادخل اجمالي الكميه">
          @error('total_quantity')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
 
     <div class="col-4">
          <label for="exampleInputFile">  سعر الوحده بدون ربح</label>
          <input type="text" class="form-control" name="price_unit" placeholder="ادخل  سعر الوحده">
          @error('price_unit')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
     <div class="col-4">
          <label for="exampleInputFile">  اجمالي التكلفه</label>
          <input type="text" class="form-control" name="total_cost" placeholder="اجمالي التكلفه">
          @error('total_cost')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
     <div class="col-4">
          <label for="exampleInputFile"> تاريخ الشراء</label>
          <input type="datetime-local" class="form-control" name="date_of_pay" placeholder="ادخل  تاريخ الشراء">
          @error('date_of_pay')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
        <!-- employees -->


<div class="col-4">
          <label for="exampleInputFile"> اسم الجندي اللي اشترا</label>
          <select name="emp_name" class="form-control">
@foreach ($employees as $employee)
    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
@endforeach
</select>
          @error('emp_name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
        <div class="col-4">
    <label for="exampleInputFile">اسم المورد</label>
    <select name="supplier_id" class="form-control">
        @foreach ($suppliers as $supplier)
            <option  >اختر مورد</option>
            <option value="{{ $supplier->id }}">{{ $supplier->id }}</option>
        @endforeach
    </select>
    @error('supplier_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

     </div>
      </div>
      <button type="submit" class="btn btn-primary">إضافة منتج </button>

      </form>

      <!-- /.card-body -->
    </div>
    </div>
  </section>
@endsection

@push('scripts-database')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('barcode-input');

    input.focus();

    input.addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault(); // تمنع الريفريش
        document.getElementById('scan-form').submit(); // تبعت الفورم يدوي
      }
    });
  });
</script>
@endpush