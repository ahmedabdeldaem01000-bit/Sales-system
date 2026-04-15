@extends('layout.app')

@section('title', 'تعديل صنف مشتريات')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">تعديل بيانات الشراء لمنتج: {{ $item->product->name }}</h3>
            </div>
            
            <form action="{{ route('purchase.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>المنتج</label>
                            <input type="text" class="form-control" value="{{ $item->product->name }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>المورد</label>
                            <input type="text" class="form-control" value="{{ $item->purchase->supplier->name }}" readonly>
                        </div>

                        <div class="mt-3 col-md-4">
                            <label>سعر الوحدة عند الشراء</label>
                            <input type="number" step="0.01" name="unit_price" id="edit_unit_price" 
                                   class="form-control" value="{{ $item->unit_price }}" required>
                            @error('unit_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-3 col-md-4">
                            <label>الكمية</label>
                            <input type="number" name="quantity" id="edit_quantity" 
                                   class="form-control" value="{{ $item->quantity }}" required>
                            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-3 col-md-4">
                            <label>إجمالي التكلفة للصنف</label>
                            <input type="text" id="edit_total_price" class="form-control" 
                                   value="{{ $item->total_price }}" readonly style="background-color: #eee;">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">تحديث البيانات والمخزن</button>
                    <a href="{{ route('purchase.index') }}" class="btn btn-default">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts-database')
<script>
    const priceInput = document.getElementById('edit_unit_price');
    const qtyInput = document.getElementById('edit_quantity');
    const totalInput = document.getElementById('edit_total_price');

    function updateCalculatedTotal() {
        const price = parseFloat(priceInput.value) || 0;
        const qty = parseFloat(qtyInput.value) || 0;
        totalInput.value = (price * qty).toFixed(2);
    }

    priceInput.addEventListener('input', updateCalculatedTotal);
    qtyInput.addEventListener('input', updateCalculatedTotal);
</script>
@endpush