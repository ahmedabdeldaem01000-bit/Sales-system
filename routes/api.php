<?php

use App\Http\Controllers\Api\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function () {
    // عرض كل المبيعات
    Route::get('/sales', [SaleController::class, 'index']);
    // إنشاء مبيعة جديدة
    Route::post('/sales', [SaleController::class, 'store']);
 
// });