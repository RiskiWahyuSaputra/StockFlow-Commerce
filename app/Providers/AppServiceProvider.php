<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $user = auth()->user();
            $isCustomer = $user && $user->isCustomer();

            $cart = once(function () use ($user, $isCustomer) {
                if (! $isCustomer) {
                    return null;
                }

                return app(\App\Services\CartService::class)->getActiveCart($user);
            });

            $view->with('cartCount', $cart?->total_items ?? 0);
            $view->with('cart', $cart);
        });
    }
}
