<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Categories;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Products - Page')]
class ProductPage extends Component
{
    use WithPagination;

    use LivewireAlert;

    protected $queryString = [
        'selectedCategories' => ['except' => []],
        'sort' => ['except' => []]
    ];

    public $sort = 'latest';

    public $price_range = 3000000;

    public $selectedCategories = [];

    // add product page cart
    public function addToCart($product_id)
{
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

        $productQuery = Product::query()->where('in_stock', 1);

        if(!empty($this->selectedCategories)){
            $productQuery->whereIn('category_id', $this->selectedCategories);
        }

        if($this->sort == 'latest'){
            $productQuery->latest();
        }

        if($this->sort == 'price'){
            $productQuery->orderBy('price');
        }
        return view('livewire.product-page', [
            'products' => $productQuery->paginate(8),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Categories::where('is_active', 1)->get(['id', 'name', 'slug'])
        ]);
    }
}
