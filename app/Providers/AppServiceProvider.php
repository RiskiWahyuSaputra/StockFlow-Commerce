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
            $cartCount = once(function (): int {
                $user = auth()->user();

                if (! $user || ! $user->isCustomer()) {
                    return 0;
                }

                return (int) ($user->activeCart()->value('total_items') ?? 0);
            });

            $view->with('cartCount', $cartCount);
        });
    }
}
