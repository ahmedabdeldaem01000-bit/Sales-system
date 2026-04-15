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
      <form action="{{ route('debtor.store') }}" method="POST">
      @csrf
<!-- 
name
price
      quantity
user
employee_id
-->
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
          <label for="exampleInputFile">سعر المنتج</label>
          <input type="text" class="form-control" name="price" placeholder="ادخل سعر المنتج">
          @error('price')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
     <div class="col-4">
          <label for="exampleInputFile">كميه المنتج</label>
          <input type="text" class="form-control" name="quantity" placeholder="ادخل كميه المنتج">
          @error('quantity')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
 
   
 
  
        <div class="col-4">
          <label for="exampleInputFile"> اسم الجندي اللي اشترا</label>
          <input type="text" class="form-control" name="user" placeholder="اسم الجندي اللي اشترا">
          @error('user')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
     
        <!-- employees -->


<div class="col-4">
          <label for="exampleInputFile"> اسم الجندي اللي باع</label>
          <select name="employee_id" class="form-control">
@foreach ($employees as $employee)
    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
@endforeach
</select>
          @error('employee_id')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
     

        <div class="col-4">
          <label for="exampleInputFile"> تاريخ</label>
          <input type="datetime-local" class="form-control" name="date" placeholder="تاريخ">
          @error('date')
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