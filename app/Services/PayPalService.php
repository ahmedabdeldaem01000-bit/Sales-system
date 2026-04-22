<?php
namespace App\Services;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    public function createPayment($order, $item)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => $order->id,
                    "amount" => [
                        "currency_code" => "USD", // تأكد إن العملة متوافقة مع حسابك
                        "value" => number_format($item->amount, 2, '.', '')
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('paypal.success', ['item_id' => $item->id]),
                "cancel_url" => route('paypal.cancel'),
            ]
        ]);
        // dd("وصلت هنا", $response);

        // سجل الـ Response في الـ log عشان لو طلع null تاني نشوف السبب
        \Log::info('PayPal Response:', $response);
     
if (isset($response['id']) && isset($response['links'])) {

    $paypalOrderId = $response['id'];

    foreach ($response['links'] as $link) {
        if ($link['rel'] === 'approve') {

            $item->paypal_order_id = $paypalOrderId;
            $item->payment_link = $link['href'];
            $item->save();
 
// dd($item->fresh());
        

            return $link['href'];
        }
    }
}
 
    
    if (!isset($response['id'])) {
        \Log::error('PayPal FAILED:', $response);
        dd($response);
}
        return null;
    }



    public function capture($token)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

  
\Log::info('Access token fetched');
        return $provider->capturePaymentOrder($token);
    }
}