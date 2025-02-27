<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ValidateCaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $recaptchaToken = $request->input('g-recaptcha-response');

        if (!$recaptchaToken) {
            return back()->withErrors(['recaptcha' => 'reCAPTCHA validation failed.']);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptchaToken,
            'remoteip' => $request->ip(),
        ]);

        $body = $response->json();

        if (!$body['success']) {
            return back()->withErrors(['recaptcha' => 'reCAPTCHA verification failed.']);
        }

        return $next($request);
    }
}
