<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstallmentItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;

class PayPalWebhookController extends Controller
{

public function verifyWebhook(Request $request)
{
    $clientId = config('paypal.sandbox.client_id');
    $secret = config('paypal.sandbox.client_secret');

    // 1. أهم خطوة: قراءة الـ Raw Body من غير أي تعديل من Laravel
    $rawBody = $request->getContent();
$rawPayload = json_decode($rawBody, true);
 
    $response = Http::withBasicAuth($clientId, $secret)
        ->post('https://api-m.sandbox.paypal.com/v1/notifications/verify-webhook-signature', [
            "transmission_id"   => $request->header('PAYPAL-TRANSMISSION-ID'),
            "transmission_time" => $request->header('PAYPAL-TRANSMISSION-TIME'),
            "cert_url"          => $request->header('PAYPAL-CERT-URL'),
            "auth_algo"         => $request->header('PAYPAL-AUTH-ALGO'),
            "transmission_sig"  => $request->header('PAYPAL-TRANSMISSION-SIG'),
            "webhook_id"        => config('paypal.sandbox.webhook_id'), 
            "webhook_event"     => $rawPayload // نبعت الـ Array اللي جاية من الـ content مباشرة
        ]);

    $verificationStatus = $response->json('verification_status');

    if ($verificationStatus !== 'SUCCESS') {
        \Illuminate\Support\Facades\Log::error('PayPal Webhook Verification Failed', [
            'http_status' => $response->status(),
            'paypal_error' => $response->json(),
            'sent_payload' => $rawPayload // سجل ده عشان تتأكد إن الداتا مفيهاش حاجة ناقصة
        ]);
        return false;
    }

    return true;
}
  public function handleWebhook(Request $request)
{
    // \Log::error('🔥 WEBHOOK HIT 🔥');
  \Illuminate\Support\Facades\Log::info('🔥 WEBHOOK HIT 🔥', $request->all());
    if (!$this->verifyWebhook($request)) {
        return response()->json(['error' => 'Invalid'], 400);
    }

    $payload = $request->all();
    $eventType = $payload['event_type'] ?? null;

    if ($eventType !== 'PAYMENT.CAPTURE.COMPLETED') {
        return response()->json(['status' => 'ignored']);
    }
    

  $paypalOrderId = 
    $payload['resource']['supplementary_data']['related_ids']['order_id']
    ?? $payload['resource']['id']
    ?? null;
 
 
    $item = InstallmentItem::where('paypal_order_id', $paypalOrderId)->first();
 
    if (!$item) {
        return response()->json(['status' => 'not_found']);
    }

    // حماية من التكرار
    if ($item->status === 'paid') {
        return response()->json(['status' => 'already_paid']);
    }

       if ($item && $item->status !== 'paid') {

    $item->update([
        'status' => 'paid',
        'paid_amount' => $item->amount,
    ]);
}
 

    Payment::create([
        'order_id' => $item->installment->order_id,
        'installment_item_id' => $item->id,
        'amount' => $item->amount,
        'method' => 'paypal',
        'payment_date' => now(),
     
    ]);

    

    return response()->json(['status' => 'success']);
}

}