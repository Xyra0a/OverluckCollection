<?php

namespace App\Livewire;

use App\Models\Categories;
use App\Models\Product;
use Livewire\Component;

class SearchProducts extends Component
{
    public $search = '';
    public $results = [];
    public $selectedProduct = [];

    protected $queryString = [
        'selectedProduct' => ['except' => []],
    ];


    public function updatedSearch($value)
    {
        if (strlen($value) > 2) {
            $products = Product::where('name', 'like', '%' . $value . '%')->get();
            $categories = Categories::where('name', 'like', '%' . $value . '%')->get();

            // Mengambil produk yang sesuai dengan kategori yang ditemukan
            $categoryProducts = Product::whereIn('category_id', $categories->pluck('id'))->get();

            $this->results = $products->merge($categoryProducts);
        } else {
            $this->results = [];
        }
    }

    public function render()
    {

        $productQuery = Product::query()->where('in_stock', 1);

        if (!empty($this->selectedProduct)) {
            $productQuery->whereIn('id', $this->selectedProduct);
        }

        return view('livewire.search-products',[
            'results' => $this->results,
            'products' => $productQuery->paginate(4),
        ]
    );
    }
}
