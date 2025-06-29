<?php

namespace App\Livewire;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderItem;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckOutPage extends Component
{
    public $items = [];
    public $grand_total = 0;
    public $snap_token = null;
    public $order_id;
    public $isProcessing = false;
    public $order;

    protected $listeners = ['paymentProcessed'];

    public function mount()
    {
        // Load cart items dan total
        $this->items = CartManagement::getCartItems();
        $this->grand_total = CartManagement::calculateCartTotalAmount($this->items);
    }

    public function createOrder()
    {
        $this->isProcessing = true;

        // Pastikan keranjang tidak kosong
        if (empty($this->items)) {
            session()->flash('error', 'Your cart is empty');
            return;
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'grand_total' => $this->grand_total + ($this->grand_total * 0.11),
            'status' => 'pending',
        ]);

        // Simpan detail item ke tabel order_items
        foreach ($this->items as $item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                session()->flash('error', "Product with ID {$item['product_id']} not found!");
                return;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_amount' => $this->grand_total,
                'taxes' => $this->grand_total * 0.11,
                'total_amount' => $this->grand_total + ($this->grand_total * 0.11),
            ]);
        }

        // Siapkan parameter pembayaran untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->grand_total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            
        ];

        try {
            // Generate Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Update order dengan Snap Token
            $order->update([
                'snap_token' => $snapToken,
            ]);

            // Simpan snap token untuk Livewire
            $this->snap_token = $snapToken;

            // Kirim event ke browser agar Midtrans Snap muncul
            $this->dispatchBrowserEvent('snap-payment', ['snap_token' => $snapToken]);
            // $this->emit('$refresh');

            session()->flash('success', 'Order created successfully. Please proceed with payment.');
            return redirect()->to("/success/{$order->id}");
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            session()->flash('error', 'Payment processing error: ' . $e->getMessage());
        }

        $this->isProcessing = false;
    }

    public function render()
    {
        return view('livewire.check-out-page',[
            'order' => Order::find($this->order_id)
        ]);
    }
}

 // public function processCheckout()
    // {
    //     if (empty($this->items)) {
    //         session()->flash('error', 'Your cart is empty');
    //         return;
    //     }

    //     \Midtrans\Config::$serverKey = 'SB-Mid-server-H6omc86Bo3v3WfsPJ_0rX98z';
    //     \Midtrans\Config::$isProduction = false;
    //     \Midtrans\Config::$isSanitized = true;
    //     \Midtrans\Config::$is3ds = true;

    //     // Ambil product_id dari cart items
    //     $productId = $this->items[0]['product_id']; // Sesuaikan dengan struktur cart Anda

    //     // Ambil data product dari database
    //     $product = Product::find($productId);

    //     if (!$product) {
    //         session()->flash('error', 'Product not found!');
    //         return;
    //     }

    //     $order = Order::create([
    //         'user_id' => Auth::id(),
    //         'grand_total' => $this->grand_total,
    //         'product_id' => $productId, // Simpan product_id
    //         'product_name' => $product->name, // Simpan product_name
    //         'status' => 'pending',
    //     ]);

    //     // Siapkan parameter pembayaran
    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $order->id,
    //             'gross_amount' => $order->grand_total,
    //         ],
    //         'customer_details' => [
    //             'first_name' => Auth::user()->name,
    //             'email' => Auth::user()->email,
    //         ],
    //     ];

    //     try {
    //         // Generate Snap Token
    //         $snapToken = \Midtrans\Snap::getSnapToken($params);

    //         // Update order dengan snap_token
    //         $order->update([
    //             'snap_token' => $snapToken,
    //         ]);

    //         // Set token untuk view Livewire
    //         $this->snap_token = $snapToken;

    //         // Dispatch event untuk memunculkan popup Midtrans
    //         $this->dispatchBrowserEvent('snap-payment', ['snap_token' => $snapToken]);

    //         session()->flash('success', 'Order created successfully. Please proceed with payment.');
    //     } catch (\Exception $e) {
    //         Log::error('Midtrans Error: ' . $e->getMessage());
    //         session()->flash('error', 'Payment processing error: ' . $e->getMessage());
    //     }
    //     // dd($order);
    // }



   // public function processCheckout()
    // {
    //      // Debug: Cek nilai server key
    //     logger('Midtrans Server Key: ' . config('midtrans.server_key'));

    //     // Set konfigurasi Midtrans
    //     \Midtrans\Config::$serverKey = 'SB-Mid-server-H6omc86Bo3v3WfsPJ_0rX98z';
    //     \Midtrans\Config::$isProduction = false;
    //     \Midtrans\Config::$isSanitized = true;
    //     \Midtrans\Config::$is3ds = true;

    //     // Ambil product_id dari cart items
    //     $productId = $this->items[0]['product_id']; // Sesuaikan dengan struktur cart Anda

    //     // Ambil data product dari database
    //     $product = \App\Models\Product::find($productId);

    //     if (!$product) {
    //         session()->flash('error', 'Product not found!');
    //         return;
    //     }
    //     // Buat transaksi
    //     $order = Order::create([
    //         'user_id' => Auth::id(),
    //         'grand_total' => $this->grand_total,
    //         'product_id' => $productId, // Simpan product_id
    //         'product_name' => $product->name, // Simpan product_name
    //         'status' => 'pending',
    //     ]);

    //     // Parameter untuk Snap Token
    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $order->id,
    //             'gross_amount' => $order->grand_total,
    //         ],
    //         'customer_details' => [
    //             'first_name' => Auth::user()->name,
    //             'email' => Auth::user()->email,
    //         ],
    //     ];

    //     // Generate Snap Token
    //     $snapToken = \Midtrans\Snap::getSnapToken($params);

    //     // Simpan Snap Token ke database
    //     $order->update(['snap_token' => $snapToken]);
    //     // dd($snapToken);

    //     // // Set Snap Token ke property Livewire
    //     // $this->snap_token = $snapToken;
    //     // $this->order_id = $order->id;

    //     // Kirim event ke javascript
    //     $this->emit('paymentReady', $snapToken);
    // }
