<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Repositories\Eloquent\PostRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Chỉ giữ lại Binding của Post ở đây nếu ông chưa chuyển nó sang RepositoryServiceProvider
        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Khai báo View Composer đúng chuẩn OOP
        View::composer('frontend.layouts.master', function ($view) {
            // Tiêm Interface thay vì gọi trực tiếp Model
            $categoryRepo = app(CategoryRepositoryInterface::class);

            // Tận dụng hàm getAllActive() đã viết sẵn trong Repository
            $view->with('globalCategories', $categoryRepo->getAllActive());
        });
    }
}
