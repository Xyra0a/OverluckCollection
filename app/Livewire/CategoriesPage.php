<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Categories;
use Livewire\Attributes\Title;

#[Title('Categories Product - Overluck Collection')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Categories::where('is_active', 1)->get();
        return view('livewire.categories-page',[
            'categories' => $categories
        ]);
    }
}
