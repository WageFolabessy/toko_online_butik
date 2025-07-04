<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Category;
use Illuminate\Support\Facades\View;

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
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('user.components.navbar', function ($view) {
            // Ambil kategori yang memiliki produk, hitung jumlah produknya, dan batasi 5 saja
            $categories = Category::has('products')->withCount('products')->latest()->take(5)->get();
            $view->with('categories', $categories);
        });
    }
}
