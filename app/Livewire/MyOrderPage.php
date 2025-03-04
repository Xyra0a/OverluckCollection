<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;



class MyOrderPage extends Component
{
    use WithPagination; // Gunakan trait pagination

    public $perPage = 10; // Jumlah item per halaman

    public function updatedPerPage($value)
    {
        $this->resetPage(); // Reset ke halaman pertama saat mengubah jumlah item per halaman
    }

    public function render()
    {
        // Ambil data order dengan pagination
        $orders = Order::where('user_id', auth()->id())->with('items')->paginate($this->perPage);

        return view('livewire.my-order-page', [
            'orders' => $orders, // Kirim data ke view
        ]);
    }
}
