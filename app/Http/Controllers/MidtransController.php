<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function handleNotification(Request $request)
    {
       // Mengambil konfigurasi Server Key
        $serverKey = config('midtrans.server_key');

        // Validasi signature key dari Midtrans
        $signatureKey = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // Cek status transaksi
        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
            $order->status = 'paid'; // Status pembayaran berhasil
        } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'expire') {
            $order->status = 'failed'; // Status pembayaran gagal atau kadaluarsa
        } elseif ($request->transaction_status == 'pending') {
            $order->status = 'pending'; // Status menunggu pembayaran
        }

        $order->save();

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}

/*

        Log::info('Midtrans Notification Received:', $payload);

        // Validasi signature key (opsional, untuk keamanan)
        $validSignatureKey = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . config('services.midtrans.server_key'));

        if ($payload['signature_key'] !== $validSignatureKey) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // Cari order berdasarkan order_id
        $order = Order::where('id', $payload['order_id'])->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status pembayaran dan payment_type berdasarkan transaction_status
        switch ($payload['transaction_status']) {
            case 'capture':
            case 'settlement':
                $order->update([
                    'status' => 'success', // Sesuaikan dengan nilai enum yang baru
                    'payment_type' => $payload['payment_type'], // Simpan metode pembayaran
                ]);
                break;
            case 'pending':
                $order->update([
                    'status' => 'pending',
                    'payment_type' => $payload['payment_type'], // Simpan metode pembayaran
                ]);
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $order->update([
                    'status' => 'failed', // Sesuaikan dengan nilai enum yang baru
                    'payment_type' => $payload['payment_type'], // Simpan metode pembayaran
                ]);
                break;
            default:
                // Tidak perlu update jika status tidak dikenali
                break;
        }

        return response()->json(['message' => 'Notification handled successfully']);
    }
*/

