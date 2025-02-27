<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        CartManagement::cleanCartItemsFromCookie();
        Auth::logout();
        return redirect('/');
    }

}
