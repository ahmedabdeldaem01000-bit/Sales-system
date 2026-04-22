@extends('layout.app')

@section('title', 'اضافه موظف')

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
      <h3 class="card-title">اضافه موظف</h3>
      </div>
      <form action="{{ route('employee.store') }}" method="POST" >
      @csrf
   
     

      <div class=" card-body">
     <div class="row ">

     
       <div class="col-4">
          <label for="exampleInputFile">اسم موظف</label>
          <input type="text" class="form-control" name="name"   required >
          @error('name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل الايميل</label>
          <input type="text" class="form-control" name="email"  required >
          @error('email')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">password</label>
          <input type="password" class="form-control" name="password"  required >
          @error('password')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل رقم الهاتف</label>
          <input type="text" class="form-control" name="phone"   required >
          @error('phone')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">عنوان موظف</label>
          <input type="text" class="form-control" name="address" required>
          @error('address')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

     </div>
      </div>
      <button type="submit" class="m-4 btn btn-primary">اضافه  </button>

      </form>

      <!-- /.card-body -->
    </div>
    </div>
  </section>
@endsection
 