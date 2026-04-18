<?php

use App\Http\Controllers\DebtorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\home;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\MinProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProcessingSaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsEmployeeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Livewire\OrdersList;
use Illuminate\Support\Facades\Route;

// ✅ أول ما تفتح المشروع يوديك على صفحة تسجيل الدخول

Route::get('/', fn() => redirect()->route('login'));


// ✅ Routes للأدمن فقط
Route::get('/dashboard', fn() => view('pages.admin.dashboard'))->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('employee', EmployeeController::class);

    Route::get('/home', [home::class, 'index'])->name('home');
    Route::get('/admin', fn() => view('pages.admin.dashboard'))->name('admin.dashboard');
    Route::get('/employees/{id}/sales', [EmployeeController::class, 'sales'])->name('employees.sales');


    Route::resource('sales-report', ProcessingSaleController::class);
    Route::resource('product', ProductController::class);
    Route::resource('user', UserController::class);
    Route::resource('installment', InstallmentController::class);

    Route::resource('debtor', DebtorController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('min_product', MinProductController::class);
    Route::resource('employee-products', ProductsEmployeeController::class);
    Route::get('/processing-sales/run', [ProcessingSaleController::class, 'processSales'])->name('processing-sales.processSales');
    Route::patch('/debts/{id}/mark-paid', [DebtorController::class, 'markAsPaid'])->name('debt.markAsPaid');
    Route::resource('purchase', PurchaseController::class);


    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::delete('/supplier/bulk-delete', [SupplierController::class, 'bulkDelete'])->name('supplier.bulkDelete');
    Route::delete('user/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete');
    Route::delete('installment-delete/bulk-delete', [InstallmentController::class, 'bulkDelete'])->name('installment-delete.bulkDelete');

    // Livewire routes for orders and installments
    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{orderId}', [OrderController::class,'show'])->name('order.show');
    Route::get('/installments/{installmentId}', [InstallmentController::class,'show'])->name('installment.show');

 });



Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::resource('employee-products', ProductsEmployeeController::class);





});

require __DIR__ . '/auth.php';





/**
  Stock Movements (حركة المخزون): كل حركة تتسجل (بيع – شراء – مرتجع – تلف)
 ____  
 نظام فواتير (Invoices)
انت بتبيع بس “سلة وخلاص”
فين:
رقم الفاتورة؟
حالة الفاتورة (مدفوعة / جزئي / مؤجلة)
لازم:
جدول invoices
جدول invoice_items
____
Backup & Restore

________
ربح كل منتج
ربح يومي / شهري

________

إجمالي المبيعات اليوم
عدد العمليات
المنتجات الأكثر مبيعًا
المنتجات اللي قربت تخلص
________

لما منتج يقل عن حد معين → تنبيه
لما حد عليه فلوس كتير → تنبيه
 */