<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController;

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
        });
    });
});

// == HALAMAN ADMIN ==
Route::prefix('admin')->name('admin.')->group(function () {

    // Rute login admin
    Route::middleware('guest')->group(function () {
        Route::get('/masuk', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
        Route::post('/masuk', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Rute panel admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/keluar', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Profil Admin
        Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

        // Manajemen Toko (menggunakan Route::resource)
        Route::resource('kategori', CategoryController::class)->except(['show'])->parameters(['kategori' => 'category']);
        Route::resource('produk', AdminProductController::class)->except(['show'])->parameters(['produk' => 'product']);
        Route::resource('pengguna-admin', AdminUserController::class)->except(['show'])->parameters(['pengguna-admin' => 'user']);
        Route::resource('banner', BannerController::class)->except(['show']);
    });
});
