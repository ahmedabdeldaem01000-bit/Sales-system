@extends('layout.app')

@section('title', 'اضافه خطه جديده')

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
          <h3 class="card-title">اضافه خطه</h3>
        </div>
        <form action="{{ route('installment.store') }}" method="POST">
          @csrf

          <div class=" card-body">
            <div class="row ">


              <div class="col-4">
                <label for="exampleInputFile">اسم الخطه</label>
                <input type="text" class="form-control" name="name" placeholder="ادخل اسم الخطة">
                @error('name')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label for="exampleInputFile">عدد الشهور</label>
                <input type="number" class="form-control" name="months_count" placeholder="ادخل  عدد الشهور">
                @error('months_count')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label for="exampleInputFile">ادخل نسبة الفايدة </label>
                <input type="number" class="form-control" name="interest_rate" placeholder="ادخل نسبة الفايدة ">
                @error('interest_rate')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>


            </div>
          </div>
          <button type="submit" class="m-4 btn btn-primary">إضافة </button>

        </form>

        <!-- /.card-body -->
      </div>
    </div>
  </section>
@endsection