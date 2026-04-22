@extends('layout.app')

@section('title', ' تعديل موظف')

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
      <h3 class="card-title"> {{ $employee->name }}تعديل موظف</h3>
      </div>
      <form action="{{ route('employee.update',$employee->id) }}" method="POST" >
      @csrf
      @method('PUT')
     

      <div class=" card-body">
     <div class="row ">

     
       <div class="col-4">
          <label for="exampleInputFile">اسم موظف</label>
          <input type="text" class="form-control" name="name"  value="{{ old('name' , $employee->name) }}" required >
          @error('name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل الايميل</label>
          <input type="text" class="form-control" name="email" value="{{ old('email' , $employee->email) }}" required >
          @error('email')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل رقم الهاتف</label>
          <input type="text" class="form-control" name="phone"  value="{{ old('phone' , $employee->phone) }}" required >
          @error('phone')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">عنوان موظف</label>
          <input type="text" class="form-control" name="address"value="{{ old('address',$employee->address) }}" required>
          @error('address')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>

     </div>
      </div>
      <button type="submit" class="m-4 btn btn-primary">تعديل  </button>

      </form>

      <!-- /.card-body -->
    </div>
    </div>
  </section>
@endsection
 