<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CartItemController;
use App\Http\Controllers\Frontend\CustomerDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'customer'])->group(function (): void {
    Route::get('/dashboard', CustomerDashboardController::class)->name('dashboard');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/items', [CartItemController::class, 'store'])->name('cart.items.store');
    Route::patch('/cart/items/{cartItem}', [CartItemController::class, 'update'])->name('cart.items.update');
    Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.items.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
