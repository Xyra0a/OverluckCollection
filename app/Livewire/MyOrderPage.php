<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MyOrderPage extends Component
{
    public $orders;


    public function mount()
    {
        // Ambil data order hanya untuk user yang sedang login
        $this->orders = Order::where('user_id', auth()->id())->get();
    }
    public function transaksi(){
        $transactions = Order::where('user_id',Auth::user()->id)->get();

        $transactions->transform(function($transaction){
            $transaction->product = collect(config('products'))->where('id',$transaction->product_id)->first();
            return $transaction;
        });
    }
    public function render()
    {
        return view('livewire.my-order-page');
    }
}
