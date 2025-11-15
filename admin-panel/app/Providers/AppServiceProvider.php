<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Purchase; // Import the Purchase Model
use App\Observers\PurchaseObserver; // Import the Observer

class AppServiceProvider extends ServiceProvider
{
    // ...

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Purchase::observe(PurchaseObserver::class);
    }
}