<?php

namespace App\Providers;

use App\Contracts\Repositories\ArchiveRepositoryContract;
use App\Contracts\Repositories\ProxyRepositoryContract;
use App\Contracts\Services\CheckProxyServiceContract;
use App\Repositories\ArchiveRepository;
use App\Repositories\ProxyRepository;
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
        $this->registerServices();
        $this->registerRepositories();
    }

    private function registerServices(): void
    {
        $this->app->singleton(CheckProxyServiceContract::class, CheckProxyService::class);
    }

    private function registerRepositories(): void
    {
        $this->app->singleton(ArchiveRepositoryContract::class, ArchiveRepository::class);
        $this->app->singleton(ProxyRepositoryContract::class, ProxyRepository::class);
    }
}
