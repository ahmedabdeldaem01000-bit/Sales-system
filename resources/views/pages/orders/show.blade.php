@extends('layout.app')
@section('content')
   <livewire:order-details   :orderId="$orderId"     />
@endsection