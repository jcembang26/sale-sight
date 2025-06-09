<?php

namespace App\Providers;

use App\Interfaces\ProductInterface;
use App\Interfaces\ProductTypeInterface;
use App\Interfaces\UserInterface;
use App\Services\ProductService;
use App\Services\ProductTypeService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(ProductInterface::class, ProductService::class);
        $this->app->bind(ProductTypeInterface::class, ProductTypeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
