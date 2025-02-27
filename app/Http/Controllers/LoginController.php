<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
            'recaptcha' => 'required',
        ]);

        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
            'response' => $request->recaptcha,
            'remoteip' => $request->ip(),
        ]);

        $body = $response->json();

        if (!$body['success']) {
            return back()->withErrors(['recaptcha' => 'reCAPTCHA validation failed.']);
        }

        return parent::authenticate($request);
    }
}
