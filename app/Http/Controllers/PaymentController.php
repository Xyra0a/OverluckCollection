<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CheckoutService;

class PaymentController extends Controller
{
    // public function success(Order $transaction)
    // {
    //     $transaction->update(['status' => 'success']);
    //     return view('checkout.success', compact('transaction'));
    // }

    // public function pending(Order $transaction)
    // {
    //     $transaction->update(['status' => 'pending']);
    //     return view('checkout.pending', compact('transaction'));
    // }

    // public function error(Order $transaction)
    // {
    //     $transaction->update(['status' => 'failed']);
    //     return view('checkout.error', compact('transaction'));
    // }

    // public function pending(Request $request){
    //     return view('/');
    // }

public function handleWebhook(Request $request)
{
    // Validasi signature key
    $serverKey = config('midtrans.server_key');
    $signatureKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    if ($signatureKey !== $request->signature_key) {
        return response()->json(['message' => 'Invalid signature key'], 403);
    }

    // Update status order
    $order = Order::find($request->order_id);
    if ($order) {
        $order->update(['status' => $request->transaction_status]);
    }

    return response()->json(['message' => 'Webhook processed successfully']);
}
}
