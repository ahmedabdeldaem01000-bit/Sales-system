@extends('layout.app')

@section('title', 'تعديل منتج')

@section('content')
<section class="content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل المنتج</h3>
            </div>

            <form action="{{ route('product.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <label>اسم المنتج</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="col-4">
                            <label>الباركود</label>
                            <input type="text" name="barcode" class="form-control" value="{{ old('barcode', $product->barcode) }}" required>
                        </div>

                        <div class="col-4">
                            <label>سعر البيع</label>
                            <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>

                        <div class="col-4">
                            <label>الكمية الكلية</label>
                            <input type="number" name="total_quantity" class="form-control" value="{{ old('total_quantity', $product->quantity) }}" required>
                        </div>

                        <div class="col-4">
                            <label>سعر الشراء للوحدة</label>
                            <input type="number" step="0.01" name="price_unit" class="form-control" value="{{ old('price_unit', $product->cost_price) }}" required>
                        </div>

                        <div class="col-4">
                            <label>اسم المورد</label>
                            <select name="supplier_id" class="form-control" required>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-4">
                            <label>تاريخ الدفع / الإضافة</label>
                            <input type="date" name="date_of_pay" class="form-control"
                                   value="{{ old('date_of_pay', \Carbon\Carbon::parse($product->created_at)->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تحديث المنتج</button>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
