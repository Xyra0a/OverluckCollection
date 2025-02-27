<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductDetailPage extends Component
{
    use LivewireAlert;

    public $slug;
    public $product;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::where('slug', $this->slug)->firstOrFail();
    }

    public function addToCart($product_id){
        $total_count = CartManagement::addCartItemToCart($product_id);

        $this->dispatch('update-cart-count',  total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to cart',[
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => $this->product
        ]);
    }
}
