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
      <form action="{{ route('supplier.store') }}" method="POST" >
      @csrf

      <div class=" card-body">
     <div class="row ">

     
       <div class="col-4">
          <label for="exampleInputFile">اسم المورد</label>
          <input type="text" class="form-control" name="name" placeholder="ادخل اسم المورد">
          @error('name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل الايميل</label>
          <input type="text" class="form-control" name="email" placeholder="ادخل الايميل">
          @error('email')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل رقم الهاتف</label>
          <input type="text" class="form-control" name="phone" placeholder="ادخل رقم الهاتف">
          @error('phone')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">عنوان المورد</label>
          <input type="text" class="form-control" name="address" placeholder="ادخل عنوان المورد">
          @error('address')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

     </div>
      </div>
      <button type="submit" class="m-4 btn btn-primary">إضافة مورد </button>

      </form>

      <!-- /.card-body -->
    </div>
    </div>
  </section>
@endsection
 