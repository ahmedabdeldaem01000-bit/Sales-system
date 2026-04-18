@extends('layout.app')
@section('content')
   <livewire:orders-list  :orders="$orders"  />
@endsection