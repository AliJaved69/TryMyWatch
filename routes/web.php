<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;

Route::get('/home', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);

Route::get('/shop', [ProductController::class, 'shop']);
Route::get('/product/{id}', [ProductController::class, 'product'])->name('product.show');

