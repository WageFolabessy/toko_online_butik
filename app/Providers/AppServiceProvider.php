<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductReview;
use App\Policies\ShoppingCartItemPolicy;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Policies\AddressPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductReviewPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::except([
            'api/midtrans/notification'
        ]);

        Gate::policy(ShoppingCartItem::class, ShoppingCartItemPolicy::class);
        Gate::policy(Address::class, AddressPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(ProductReview::class, ProductReviewPolicy::class);

        View::composer(['customer.layouts.navbar', 'customer.layouts.footer'], function ($view) {
            $footerCategories = Category::take(5)->get();

            $cartItemCount = 0;
            if (Auth::check()) {
                $cart = ShoppingCart::where('user_id', auth()->id())->first();
                if ($cart) {
                    $cartItemCount = $cart->items()->sum('qty');
                }
            }

            $view->with('footerCategories', $footerCategories)
                ->with('cartItemCount', $cartItemCount);
        });
    }
}
