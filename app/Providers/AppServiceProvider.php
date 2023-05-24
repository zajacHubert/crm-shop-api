<?php

namespace App\Providers;

use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use App\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
