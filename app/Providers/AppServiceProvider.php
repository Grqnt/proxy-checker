<?php

namespace App\Providers;

use App\Contracts\Services\CheckProxyServiceContract;
use App\Services\CheckProxyService;
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
        $this->app->singleton(CheckProxyServiceContract::class, CheckProxyService::class);
    }
}
