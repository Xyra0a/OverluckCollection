<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Categories;
use Livewire\Attributes\Title;

#[Title('Overluck Collection')]

class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Categories::where('is_active', 1)->get();
        $products = Product::where('in_stock', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
