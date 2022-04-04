<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Image\ImageRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Gender\GenderRepository;
use App\Repositories\Voucher\VoucherRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Gender\GenderRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->singleton(
            ImageRepositoryInterface::class,
            ImageRepository::class
        );
        $this->app->singleton(
            VoucherRepositoryInterface::class,
            VoucherRepository::class
        );
        $this->app->singleton(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->singleton(
            GenderRepositoryInterface::class,
            GenderRepository::class
        );
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('layouts.app', function ($view) {
            $categories = Category::with('childCategories.childCategories')->get();
            $categories =
                $view->with('categories', $categories);
        });
    }
}
