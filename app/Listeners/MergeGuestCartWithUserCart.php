<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Helpers\CartManagement;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MergeGuestCartWithUserCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $guestCartItems = CartManagement::getCartItemsFromCookie();

        foreach ($guestCartItems as $item) {
            // Cek apakah item sudah ada di cart user
            $existingCartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $item['product_id'])
                ->first();

            if ($existingCartItem) {
                // Jika item sudah ada, update quantity
                $existingCartItem->quantity += $item['quantity'];
                $existingCartItem->save();
            } else {
                // Jika item belum ada, tambahkan ke cart user
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        // Hapus cart dari cookie setelah digabungkan
        CartManagement::cleanCartItemsFromCookie();
    }
}
