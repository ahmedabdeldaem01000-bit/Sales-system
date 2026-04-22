<?php

namespace App\Http\Controllers;

use App\Models\InstallmentItem;
use App\Models\Order;
 
use App\Services\PayPalService;
use Illuminate\Http\Request;
 
class PayPalController extends Controller
{


 

public function success(Request $request)
{

    // dd('OK ROUTE WORKING');
    //    dd([
    //     'token' => $request->token,
    //     'payer' => $request->PayerID,
    //     'item_id' => $request->item_id,
    // ]);
    try {

        $token = $request->token;

        if (!$token) {
            abort(400, 'Missing token');
        }

        $result = app(PayPalService::class)->capture($token);

        if (!isset($result['status']) || $result['status'] !== 'COMPLETED') {
            \Log::error('Capture failed', $result);
            return response()->json(['error' => 'Payment failed'], 400);
        }

        return redirect()->route('order-create.index')->with('success', 'Payment successful');

    } catch (\Throwable $e) {
        \Log::error('Success route crash', [
            'error' => $e->getMessage()
        ]);

        abort(500, 'Payment processing error');
    }
}
}
 
