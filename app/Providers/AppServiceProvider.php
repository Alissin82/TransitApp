<?php

namespace App\Providers;

use App\Models\TransitLine;
use App\Observers\TransitLineObserver;
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
        TransitLine::observe(TransitLineObserver::class);
    }
}
