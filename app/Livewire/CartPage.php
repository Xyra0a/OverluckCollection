<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{
    public $cart_items = [];
    public $grand_total = 0;


    public function mount(){
        $this->cart_items = CartManagement::getCartItems(); // Ganti ke method baru
        $this->grand_total = CartManagement::calculateCartTotalAmount($this->cart_items);
    }

    public function removeItem($product_id){
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $product_id)
                ->delete();
        } else {
            $this->cart_items = CartManagement::removeCartItemFromCart($product_id);
        }

        $this->cart_items = CartManagement::getCartItems(); // Refresh data
        $this->grand_total = CartManagement::calculateCartTotalAmount($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items));
    }
    public function render()
    {
        return view('livewire.cart-page');
    }
}
