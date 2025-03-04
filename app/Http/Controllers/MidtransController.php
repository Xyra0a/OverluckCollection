<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = $request->all();

        Log::info('Incoming midtrans', [
            'payload' => $payload
        ]);

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];

        $reqSignature = $payload['signature_key'];
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.serverKey'));

        if($signature !== $reqSignature) {
            return response()->json([
                'message' => 'Invalid signature key'
            ], 401);
        }

        $transactionStatus = $payload['transaction_status'];
        $order = Order::find($orderId);

        if(!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        if ($transactionStatus === 'settlement') {
            $order->status = 'settl ement';
            $order->payment_type = $payload['payment_type'];
            $order->acquirer = $payload['acquirer'] ?? null;

            // Pastikan bank dan va_number diambil dari va_numbers jika payment_type adalah bank_transfer
            if ($order->payment_type === 'bank_transfer' && isset($payload['va_numbers'][0])) {
                $order->bank = $payload['va_numbers'][0]['bank'] ?? null;
                $order->va_number = $payload['va_numbers'][0]['va_number'] ?? null;
            } else {
                $order->bank = $payload['bank'] ?? null;
                $order->va_number = $payload['va_number'] ?? null;
            }

            CartManagement::removeItemsByOrder($order->id);
            $order->save();
            Log::info('Order saved', ['bank' => $order->bank, 'va_number' => $order->va_number]);
        } else if ($transactionStatus === 'expire') {
            $order->status = 'expired';
            $order->save();
        }

          // $order->va_number = isset($payload['va_numbers'][0]['va_number']) ? $payload['va_numbers'][0]['va_number'] : 'Tidak menggunakan pembayaran dengan metode ini';
            // $order->bank = isset($payload['bank']) ? $payload['bank'] : 'Tidak menggunakan pembayaran dengan metode ini';

        return response()->json([
            'message' => 'Success'
        ], 200);

    }
    // public function handleNotification(Request $request)
    // {
    //     Log::info('Midtrans Notification Received:', $request->all());

    //     // Ambil konfigurasi Server Key dari .env
    //     $serverKey = config('midtrans.server_key');

    //     // Validasi signature key dari Midtrans
    //     $calculatedSignatureKey = hash("sha512",
    //         $request->order_id .
    //         $request->status_code .
    //         $request->gross_amount .
    //         $serverKey
    //     );
    //     dd($calculatedSignatureKey);

    //     if ($calculatedSignatureKey !== $request->signature_key) {
    //         Log::error('Invalid signature key detected');
    //         abort(403, 'Invalid signature key');
    //     }

    //     // Cari order berdasarkan order_id
    //     $order = Order::where('id', $request->order_id)->first();

    //     if (!$order) {
    //         Log::error('Order not found for ID: ' . $request->order_id);
    //         return response()->json(['message' => 'Transaction not found'], 404);
    //     }

    //     // Update status berdasarkan status transaksi Midtrans
    //     $midtransStatus = $request->transaction_status;

    //     switch ($midtransStatus) {
    //         case 'settlement':
    //         case 'capture':
    //             $order->status = 'settlement'; // Sesuai dengan ENUM di tabel
    //             break;
    //         case 'pending':
    //             $order->status = 'pending';
    //             break;
    //         case 'expire':
    //             $order->status = 'expired';
    //             break;
    //         case 'cancel':
    //         case 'deny':
    //             $order->status = 'failed';
    //             break;
    //         default:
    //             Log::warning("Unknown Midtrans status: $midtransStatus");
    //             return response()->json(['message' => 'Unknown transaction status'], 400);
    //     }

    //     $order->save();

    //     Log::info("Order ID: {$order->id} updated to status: {$order->status}");

    //     return response()->json(['message' => 'Webhook processed successfully']);
    // }
}
