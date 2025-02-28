<?php

namespace App\Livewire\Partials;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Helpers\CartManagement;
use App\Models\Categories;
use Livewire\WithBrowserEvents;

class Navbar extends Component
{

    public $total_count = 0;

    public function mount(){
        $this->total_count = count(CartManagement::getCartItems()); // Ganti ke method baru
        // $this->dispatch('init-search'); // Sekarang method ini tersedia
    }

    #[On('update-cart-count')]
    public function updateCartCount($total_count){
        $this->total_count = $total_count;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
