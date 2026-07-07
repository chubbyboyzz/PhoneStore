<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        \App\Repositories\Contracts\ProductRepositoryInterface::class,
        \App\Repositories\Eloquent\ProductRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('frontend.layouts.master', function ($view) {
            $categories = Category::with('brands')->orderBy('name', 'asc')->get();
            $view->with('categories', $categories);
        });
    }
}
