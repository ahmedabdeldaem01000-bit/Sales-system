<div class="p-3 mb-4 card">
    <h5>إضافة منتج بواسطة الباركود</h5>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="form-group">
        <label for="barcode">الباركود:</label>
        <input type="text" class="form-control" id="barcode" wire:model.lazy="barcode" placeholder="ادخل الباركود">
    </div>

    {{-- ✅ عرض المنتج بعد البحث --}}
    @if($product)
        <div class="p-3 mt-3 border rounded">
            <h6 class="mb-2">{{ $product->name }}</h6>
            <p><strong>السعر:</strong> {{ $product->price }} جنيه</p>

            <div class="form-group">
                <label>الكمية:</label>
                <input type="number" class="form-control" wire:model="quantity" min="1">
            </div>

            <button class="mt-2 btn btn-success" wire:click="addToCart">
                <i class="fas fa-cart-plus"></i> أضف إلى السلة
            </button>
        </div>
    @endif

    {{-- ✅ عرض السلة --}}
    @if (session()->has('cart') && count(session('cart')) > 0)
        <div class="flex flex-row flex-wrap items-center justify-between mt-4 card">

            <div class="flex flex-row flex-wrap items-start content-center justify-start gap-4 card-body col-6">
                @foreach ($cart as $index => $item)
                    <div class="p-3 mb-3 border rounded col-5">
                        <h6>{{ $item['name'] }}</h6>
                        <p><strong>السعر:</strong> {{ $item['price'] }} جنيه</p>
                        <p><strong>الإجمالي للمنتج:</strong> {{ $item['price'] * $item['quantity'] }} جنيه</p>

                        {{-- تعديل الكمية --}}
                        <div class="form-group">
                            <label>الكمية:</label>
                            <input type="number" wire:model.defer="cart.{{ $index }}.quantity" class="form-control" min="1">
                            <button wire:click="syncCart({{ $index }})" class="mt-2 btn btn-sm btn-primary">تحديث</button>

                        </div>

                        {{-- زر الحذف --}}
                        <button class="mt-2 btn btn-danger" wire:click="removeItem({{ $index }})">
                            <i class="fas fa-trash"></i> حذف المنتج
                        </button>

                    </div>
                @endforeach

                {{-- الإجمالي الكلي --}}
                <div class="mt-3 alert alert-info">
                    <strong>الإجمالي الكلي:</strong> {{ $this->total }} جنيه
                </div>
                <div class="mt-3 form-check">
                    <input class="form-check-input" type="checkbox" id="isDebtor" wire:model="is_debtor">
                    <label class="form-check-label" for="isDebtor">
                        عملية شراء غير مدفوعة
                    </label>
                </div>
                @if($is_debtor)
                    <div class="mt-3 form-group">
                        <label for="customerName">اسم العميل:</label>
                        <input type="text" id="customerName" class="form-control" wire:model.defer="customer_name"
                            placeholder="ادخل اسم العميل">
                    </div>
                @endif
                {{-- زر تأكيد الطلب --}}
                <button class="mt-3 btn btn-success" wire:click="confirmOrder">
                    <i class="fas fa-check"></i> تأكيد الطلب
                </button>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Minimal</label>
                            <select class="form-control select2" style="width: 100%;">
                                <option selected="selected">Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    @endif
</div>

@push('scripts-database')
    <script>
        window.addEventListener('open-print-page', event => {
            // نفتح صفحة الفاتورة ونمرر لها الـ ID
            const url = '/print-order/' + event.detail.orderId;
            const printWindow = window.open(url, '_blank', 'width=800,height=600');

            // بمجرد التحميل نقوم بالطباعة
            printWindow.onload = function () {
                printWindow.print();
            };
        });
    </script>
@endpush