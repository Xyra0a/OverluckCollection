<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Livewire\Component;

class SuccessPage extends Component
{

    public $order;
    public function mount($id)
    {
        $this->order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    }

    public function render()
    {
        // Ambil order beserta order_items-nya
        $order = Order::where('user_id', auth()->id())
                     ->with('items') // Eager load relasi orderItems
                    ->first();

        return view('livewire.success-page', [
            'order' => $order
        ]);
    }
}
