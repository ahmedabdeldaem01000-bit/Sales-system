<?php

 
use App\Http\Controllers\Api\PayPalWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// APi
 Route::post('paypal/webhook',[PayPalWebhookController::class,'handleWebhook']);
//  Route::post('/paypal/webhook', [PayPalWebhookController,class, 'handleWebhook']);