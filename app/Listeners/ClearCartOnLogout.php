<?php

namespace App\Listeners;

use App\Helpers\CartManagement;
use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearCartOnLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
          // Hanya hapus cart dari cookie, jangan hapus dari database
        CartManagement::cleanCartItemsFromCookie();
    }
}
