 @extends('layout.app')

@section('title', 'لوحة الموظف')

@section('content')
    <h4>إضافة منتج بالباركود</h4>

   <livewire:scan-product  :users="$users"  :installments="$installments" />
@endsection
