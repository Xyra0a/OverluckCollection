<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
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

// public function handleWebhook(Request $request)
// {
//     // Validasi signature key
//     $serverKey = config('midtrans.server_key');
//     $signatureKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

//     if ($signatureKey !== $request->signature_key) {
//         return response()->json(['message' => 'Invalid signature key'], 403);
//     }

//     // Update status order
//     $order = Order::find($request->order_id);
//     if ($order) {
//         $order->update(['status' => $request->transaction_status]);
//     }

//     return response()->json(['message' => 'Webhook processed successfully']);
// }

// public function generateSnapToken(Request $request)
//     {
//         // Validasi request
//         $request->validate([
//             'order_id' => 'required|exists:orders,id'
//         ]);

//         // Ambil order dari database
//         $order = Order::findOrFail($request->order_id);

//         try {
//             // Konfigurasi Midtrans
//             Config::$serverKey = env('MIDTRANS_SERVER_KEY');
//             Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
//             Config::$isSanitized = true;
//             Config::$is3ds = true;

//             // Siapkan parameter pembayaran
//             $params = [
//                 'transaction_details' => [
//                     'order_id' => $order->id,
//                     'gross_amount' => $order->grand_total,
//                 ],
//                 'customer_details' => [
//                     'first_name' => $order->user->name,
//                     'email' => $order->user->email,
//                 ]
//             ];

//             // Generate Snap Token
//             $snapToken = Snap::getSnapToken($params);

//             // Response JSON
//             return response()->json([
//                 'status' => 'success',
//                 'snap_token' => $snapToken
//             ]);

//         } catch (\Exception $e) {
//             // Handle error
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }
}
