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


                @if(empty($users))
                <div class="form-group">
                    <label>اختر العميل</label>
                        <select name="user" class="form-control select2" style="width: 100%;">
                            <option selected="selected">no user found</option>


                        </select>
                        </div>
                    @else
<div class="form-group">
    <label>اختيار العميل</label>
    <select wire:model="selected_user_id" class="form-control">
        <option value="">-- اختر عميل --</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>
                    @endif


                {{-- الإجمالي الكلي --}}
                <div class="mt-3 alert alert-info">
                    <strong>الإجمالي الكلي:</strong> {{ $this->total }} جنيه
                </div>
               <div class="mt-3 form-group">
    <label>طريقة الدفع</label>

    <select wire:model="payment_type" class="form-control">
        <option value="cash">كاش</option>
        <option value="installment">تقسيط</option>
    </select>
</div>
           @if($payment_type === 'installment')

<div class="mt-3 form-group">
    <label>اختيار خطة التقسيط</label>
    <select wire:model="selected_installments_id" class="form-control">
        <option value="">-- اختر الخطة --</option>
        @foreach($installments as $plan)
            <option value="{{ $plan->id }}">
                {{ $plan->name }} ({{ $plan->months_count }} شهر)
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>المقدم</label>
    <input type="number" class="form-control" wire:model="down_payment" min="0">
</div>

<div class="form-group">
    <label>تاريخ البداية</label>
    <input type="date" class="form-control" wire:model="start_date">
</div>

@endif
                {{-- زر تأكيد الطلب --}}
                <button class="mt-3 btn btn-success" wire:click="confirmOrder">
                    <i class="fas fa-check"></i> تأكيد الطلب
                </button>
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