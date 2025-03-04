<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\MyAccount;
use App\Filament\Auth\Login;
use App\Livewire\CancelPage;
use Illuminate\Http\Request;
use App\Livewire\MyOrderPage;
use App\Livewire\ProductPage;
use App\Livewire\SuccessPage;
use App\Livewire\CheckOutPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\ResetPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\ForgotPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductPage::class)->name('products');
Route::get('/products/{slug}', ProductDetailPage::class);
Route::get('/cart', CartPage::class);

// // Auth

Auth::routes([
    'verify' => true
]);

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot', ForgotPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPage::class)->name('password.reset');
    Route::get('auth/google', [LoginPage::class, 'goTo'])->name('google.login');
    Route::get('auth/google/call-back', [LoginPage::class, 'callback'])->name('google.callback');
});

// Auth Protected
Route::middleware('auth','verified')->group(function () {
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/checkout', CheckOutPage::class)->name('checkout');
    Route::post('/generate-snap-token', [PaymentController::class, 'generateSnapToken']);

    Route::get('/my-account', MyAccount::class)->name('my-account');
    Route::get('/my-orders', MyOrderPage::class);
    Route::get('/my-orders/{order}', MyOrderDetailPage::class);
    Route::get('/success/{id}', SuccessPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('checkout.cancel');
});


// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
