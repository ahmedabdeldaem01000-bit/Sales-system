@extends('layout.app')

@section('title', 'اضافه عميل')

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
      <h3 class="card-title">اضافه عميل</h3>
      </div>
      <form action="{{ route('user.update',$user->id) }}" method="POST" >
      @csrf
      @method('PUT')
     

      <div class=" card-body">
     <div class="row ">

     
       <div class="col-4">
          <label for="exampleInputFile">اسم العميل</label>
          <input type="text" class="form-control" name="name"  value="{{ old('name' , $user->name) }}" required >
          @error('name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل الايميل</label>
          <input type="text" class="form-control" name="email" value="{{ old('email' , $user->email) }}" required >
          @error('email')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">ادخل رقم الهاتف</label>
          <input type="text" class="form-control" name="phone"  value="{{ old('phone' , $user->phone) }}" required >
          @error('phone')
        <div class="text-danger">{{ $message }}</div>
      @enderror
        </div>
       <div class="col-4">
          <label for="exampleInputFile">عنوان العميل</label>
          <input type="text" class="form-control" name="address"value="{{ old('address',$user->address) }}" required>
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
 