@extends('layout.app')

@section('title', 'اضافه منتج')

@section('content')
  <section class="content">
<style>
  form{
    display: flex;
    margin-bottom: 1rem;
    justify-content: center;
    flex-wrap: wrap;
  }
</style>
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

    <div class="container-fluid">
    <div class="card card-danger">
      <div class="card-header">
      <h3 class="card-title">اضافه منتج</h3>
      </div>
      <form action="{{ route('sales.store') }}"  method="POST">
      @csrf

      <div class="card-body">
        <div class="row ">

        <!-- اسم المنتج -->
        <div class="col-4">
          <label for="exampleInputFile"> اسم المنتج</label>
          <select name="product_id" class="form-control">
          @foreach ($Products as $product)
        <option value="{{ $product->id }}">{{ $product->name }}</option>
      @endforeach
          </select>
          @error('name')


        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
        <!-- اسم الجندي اللي باع -->
        <div class="col-4">
          <label for="exampleInputFile"> اسم  البائع</label>
          <select name="employee_id" class="form-control">
          @foreach ($Employees as $Employee)
        <option value="{{ $Employee->id }}">{{ $Employee->name }}</option>
      @endforeach
          </select>
          @error('emp_name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

        <!-- اسم المورد -->
        <!-- <div class="col-4">
          <label for="exampleInputFile">اسم المورد</label>
          <select name="supplier_id" class="form-control">
          @foreach ($Suppliers as $Supplier)
        <option>اختر مورد</option>
        <option value="{{ $Supplier->id }}">{{ $Supplier->name }}</option>
      @endforeach
          </select>
          @error('supplier_id')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div> -->




        <!--سعر الوحده بدون ربح   -->
        <div class="col-4">
          <label for="exampleInputFile"> سعر الوحده بدون ربح</label>
          <input type="text" class="form-control" value="{{ old('price_unit') }}" name="price_unit" placeholder="سعر الوحده بدون ربح">
          @error('price_unit')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

    <!-- سعر الوحده بالربح -->
    <div class="col-4">
          <label for="exampleInputFile"> سعر الوحده بالربح</label>
          <input type="text" class="form-control" name="price_profit" placeholder="ادخل  سعر الوحده">
          @error('price_profit')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

        <!-- اجمال الكميه  -->
        <div class="col-4">
          <label for="exampleInputFile">اجمال الكميه المباعه</label>
          <input type="text" class="form-control" name="quantity" placeholder="ادخل اجمالي الكميه">
          @error('total_quantity')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

    
        <!-- تاريخ الشراء -->
        <div class="col-4">
          <label for="exampleInputFile"> تاريخ الشراء</label>
          <input type="datetime-local" class="form-control" name="date_of_pay" placeholder="ادخل  تاريخ الشراء">
          @error('date_of_pay')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>




        </div>
      </div>
      <button type="submit" class="btn btn-primary">إضافة جندي</button>

      </form>

      <!-- /.card-body -->
    </div>
    </div>
  </section>
@endsection