<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\Auth\ForgotPasswordController;
use App\Http\Controllers\Customer\Auth\ResetPasswordController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;

// == HALAMAN Pelanggan ==
Route::name('customer.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/koleksi', [CustomerProductController::class, 'index'])->name('products.index');
    Route::get('/produk/{product:slug}', [CustomerProductController::class, 'show'])->name('products.show');

    // Rute yang belum login
    Route::middleware('guest')->group(function () {
        Route::get('/masuk', [CustomerAuthController::class, 'showLoginForm'])->name('login.form');
        Route::post('/masuk', [CustomerAuthController::class, 'login'])->name('login.submit');
        Route::get('/daftar', [CustomerAuthController::class, 'showRegisterForm'])->name('register.form');
        Route::post('/daftar', [CustomerAuthController::class, 'register'])->name('register.submit');
        Route::get('/lupa-password', [ForgotPasswordController::class, 'create'])->name('password.request');
        Route::post('/lupa-password', [ForgotPasswordController::class, 'store'])->name('password.email');
        Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
    });

    // Rute untuk pelanggan yang sudah login
    Route::middleware('auth')->group(function () {
        Route::post('/keluar', [CustomerAuthController::class, 'logout'])->name('logout');

        // Keranjang Belanja
        Route::prefix('keranjang')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/tambah', [CartController::class, 'store'])->name('store');
            Route::patch('/update/{shoppingCartItem}', [CartController::class, 'update'])->name('update');
            Route::delete('/hapus/{shoppingCartItem}', [CartController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('profil')->name('profile.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('edit');
            Route::put('/', [\App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('update');

            Route::resource('alamat', \App\Http\Controllers\Customer\AddressController::class)->except(['show']);

            Route::get('/pesanan', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
            Route::get('/pesanan/{order:order_number}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
            Route::post('/pesanan/{order}/konfirmasi', [\App\Http\Controllers\Customer\OrderController::class, 'confirmReceipt'])->name('orders.confirm');

            Route::post('/ulasan', [\App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('ulasan.store');
            Route::put('/ulasan/{review}', [\App\Http\Controllers\Customer\ReviewController::class, 'update'])->name('ulasan.update');
            Route::delete('/ulasan/{review}', [\App\Http\Controllers\Customer\ReviewController::class, 'destroy'])->name('ulasan.destroy');
        });

        Route::prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('index');
            Route::post('/shipping-cost', [\App\Http\Controllers\Customer\CheckoutController::class, 'calculateShippingCost'])->name('shipping_cost');
            Route::post('/place-order', [\App\Http\Controllers\Customer\CheckoutController::class, 'placeOrder'])->name('place_order');
        });

        Route::post('/fcm-token', [\App\Http\Controllers\Customer\DeviceTokenController::class, 'store'])->name('fcm.token.store');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/masuk', [AdminAuthController::class, 'showLoginForm'])->middleware('guest')->name('login.form');
    Route::post('/masuk', [AdminAuthController::class, 'login'])->middleware('guest')->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/keluar', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('kategori')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/tambah', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{category}/ubah', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('produk')->name('products.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminProductController::class, 'create'])->name('create');
            Route::post('/', [AdminProductController::class, 'store'])->name('store');
            Route::get('/{product}/ubah', [AdminProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pesanan')->name('orders.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
            Route::put('/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('update');
        });

        Route::prefix('pelanggan')->name('customers.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('index');
            Route::get('/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('show');
        });

        Route::prefix('ulasan-produk')->name('reviews.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ProductReviewController::class, 'index'])->name('index');
            Route::delete('/{review}', [\App\Http\Controllers\Admin\ProductReviewController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pengguna-admin')->name('admins.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::get('/{user}/ubah', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        });

        Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

        Route::prefix('banner')->name('banners.')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('index');
            Route::get('/tambah', [BannerController::class, 'create'])->name('create');
            Route::post('/', [BannerController::class, 'store'])->name('store');
            Route::get('/{banner}/ubah', [BannerController::class, 'edit'])->name('edit');
            Route::put('/{banner}', [BannerController::class, 'update'])->name('update');
            Route::delete('/{banner}', [BannerController::class, 'destroy'])->name('destroy');
        });

        Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    });
});
