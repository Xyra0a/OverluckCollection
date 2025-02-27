<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Filament\Auth\Login;
use App\Livewire\CancelPage;
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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\GoogleAuthController;

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

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot', ForgotPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPage::class)->name('password.reset');
    Route::get('auth/google', [LoginPage::class, 'goTo'])->name('google.login');
    Route::get('auth/google/call-back', [LoginPage::class, 'callback'])->name('google.callback');
});

// Auth Protected
Route::middleware('auth')->group(function () {
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/checkout', CheckOutPage::class)->name('checkout');
    Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('notification');
    // Route::post('/midtrans/webhook', [PaymentController::class, 'handleWebhook']);
    Route::get('/my-orders', MyOrderPage::class);
    Route::get('/my-orders/{order}', MyOrderDetailPage::class);
    Route::get('/success', SuccessPage::class)->name('checkout.success');
    Route::get('/cancel', CancelPage::class)->name('checkout.cancel');
});

// Route::prefix('checkout')->group(function () {
//     Route::get('/success/{transaction}', [PaymentController::class, 'success'])
//         ->name('checkout.success');

    // Route::get('/pending/{transaction}', [PaymentController::class, 'pending'])
    //     ->name('checkout.pending');

//     Route::get('/error/{transaction}', [PaymentController::class, 'error'])
//         ->name('checkout.error');
// });
