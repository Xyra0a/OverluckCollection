<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Detail Product - Overluck Collection')]
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
        // Cek apakah user sudah login
    if (!Auth::check()) {
        session()->flash('error', 'You must login first to add items to cart.');
        return redirect()->route('login', [
            'redirect' => url()->current() // Simpan URL saat ini
        ]);
    }

    // Tambahkan produk ke keranjang
    $message = CartManagement::addCartItemToCart($product_id);

    // Jika produk sudah ada di keranjang, tampilkan pesan error
    if ($message === 'Product Already in Cart') {
        $this->alert('error', 'Product is already in your cart', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);
        return;
    }

    // Jika produk berhasil ditambahkan, tampilkan pesan sukses
    $this->alert('success', 'Product added to cart', [
        'position' => 'bottom-end',
        'timer' => 3000,
        'toast' => true
    ]);

    // Perbarui jumlah item di keranjang
    $total_count = CartManagement::getCartCount();
    $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => $this->product
        ]);
    }
}
