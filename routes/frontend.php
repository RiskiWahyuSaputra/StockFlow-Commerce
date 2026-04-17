<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/cart', CartController::class)->name('cart.index');
Route::get('/checkout', CheckoutController::class)->name('checkout.index');

Route::controller(ProductController::class)
    ->prefix('products')
    ->as('products.')
    ->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}', 'show')->name('show');
    });
