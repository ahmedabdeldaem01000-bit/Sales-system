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
          <h3 class="card-title">تعديل خطه</h3>
        </div>
        <form action="{{ route('installment.update',$installment->id) }}" method="POST">
          @csrf
 @method('PUT')
          <div class=" card-body">
            <div class="row ">


              <div class="col-4">
                <label for="exampleInputFile">اسم الخطه</label>
                <input type="text" class="form-control" name="name" value='{{ old($installment->name) }}'  >
                @error('name')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label for="exampleInputFile">عدد الشهور</label>
                <input type="number" class="form-control" name="months_count" value='{{ old($installment->months_count) }}'>
                @error('months_count')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label for="exampleInputFile">ادخل نسبة الفايدة </label>
                <input type="number" class="form-control" name="interest_rate" value='{{ old($installment->interest_rate) }}'>
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