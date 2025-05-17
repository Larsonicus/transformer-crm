<?php

namespace App\Providers;

use App\Helpers\TaskHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TaskHelper::class, function ($app) {
            return new TaskHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('navigation', \App\View\Components\Navigation::class);
    }
}
