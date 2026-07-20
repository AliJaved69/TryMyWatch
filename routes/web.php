<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\VirtualTryOnController;
use App\Http\Controllers\StaticTryOnController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\OrderTrackingController;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

// Public Routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'sendMessage'])->name('contact.send');

// Chatbot Route
Route::post('/chatbot', [ChatbotController::class, 'handle'])->name('chatbot.handle');

Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [ProductController::class, 'product'])->name('product.show');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Checkout (Public)
Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Order Tracking (Public)
Route::get('/track-order', [OrderTrackingController::class, 'track'])->name('order.track');

// Watch Try-on (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/watch/{id}/try', [WatchController::class, 'try'])->name('watch.try');
    Route::get('/watch/form', [WatchController::class, 'showForm'])->name('watch.form');  
    Route::post('/watch/upload', [WatchController::class, 'store'])->name('watch.store');
});

// Virtual Try-On Routes
Route::get('/product/{id}/ar', [VirtualTryOnController::class, 'ar'])->name('product.ar');
Route::get('/product/{id}/try-on-upload', [VirtualTryOnController::class, 'showUploadForm'])->name('product.try-on-upload');

// AI Static Try-On (New)
Route::prefix('static-try-on')->name('static.')->group(function () {
    Route::get('/', [StaticTryOnController::class, 'index'])->name('index');
    Route::post('/generate', [StaticTryOnController::class, 'generate'])
        ->middleware('credits')
        ->name('generate');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::resource('categories',   CategoryController::class);
    Route::resource('contact',  AdminContactController::class)->only(['index', 'show', 'destroy']);
});