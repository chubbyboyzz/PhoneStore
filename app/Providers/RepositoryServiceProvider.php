<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;

use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Eloquent\AdminRepository;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Eloquent\OrderRepository;
use \App\Repositories\Contracts\CustomerRepositoryInterface;
use \App\Repositories\Eloquent\CustomerRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 1. Đăng ký cho module Sản phẩm
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        // 2. Đăng ký cho module Danh mục
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        // 3. Đăng ký cho module Quản trị viên
        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );

        // 4. Đăng ký cho module Đơn hàng
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        // 5. Đăng ký cho module Khách hàng
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
