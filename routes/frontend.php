<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Payments\MidtransWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::post('/payments/midtrans/notification', MidtransWebhookController::class)
    ->name('payments.midtrans.notification');

Route::controller(ProductController::class)
    ->prefix('products')
    ->as('products.')
    ->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}', 'show')->name('show');
    });
