<?php

namespace App\Providers;

use App\Services\Contracts\RequestServiceInterface;
use App\Services\RequestService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RequestServiceInterface::class, RequestService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 