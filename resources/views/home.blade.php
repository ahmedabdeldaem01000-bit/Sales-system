@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
  <div class="container">


    <div class="row">



    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="row">
      <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
        <div class="inner">
          <h4>{{ $totalUnpaid }} ج.م</h4>
          <p>إجمالي المديونية</p>
        </div>
        <div class="icon">
          <i class="fas fa-hand-holding-usd"></i>
        </div>
        <a href="{{ route('debtor.index') }}" class="small-box-footer">
          تفاصيل أكثر <i class="fas fa-arrow-circle-left"></i>
        </a>
        </div>
      </div>

      <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
        <div class="inner">
          <h4>{{ $salesCount }}</h4>
          <p>عدد المبيعات</p>
        </div>
        <div class="icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <a href="#" class="small-box-footer">
          تفاصيل أكثر <i class="fas fa-arrow-circle-left"></i>
        </a>
        </div>
      </div>

      <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
        <div class="inner">
          <h4>{{ $customersCount }}</h4>
          <p>عدد العملاء</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
        <a href="{{ route('debtor.index') }}" class="small-box-footer">
          تفاصيل أكثر <i class="fas fa-arrow-circle-left"></i>
        </a>
        </div>
      </div>
      </div>



    </div>



    </div>

  @endsection