<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use Stripe\Stripe;
use Stripe\PaymentIntent;

Route::get('/', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);

Route::get('/shop', [ProductController::class, 'shop']);
Route::get('/product/{id}', [ProductController::class, 'product'])->name('product.show');

Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
