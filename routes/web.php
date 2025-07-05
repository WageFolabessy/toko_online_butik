<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController;

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\Auth\AuthenticatedSessionController as UserAuthenticatedSessionController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);
    });

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

        Route::resource('kategori', CategoryController::class)->parameters([
            'kategori' => 'category'
        ]);

        Route::resource('produk', AdminProductController::class)->parameters([
            'produk' => 'product'
        ]);

        Route::resource('pelanggan', CustomerController::class)->only(['index', 'show'])->parameters([
            'pelanggan' => 'customer'
        ]);

        Route::resource('admin', AdminController::class)->parameters([
            'admin' => 'admin'
        ]);

        Route::resource('banner', BannerController::class)->except('show')->parameters([
            'banner' => 'banner'
        ]);

        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [UserProductController::class, 'index'])->name('products.index');
Route::get('/kategori/{category:slug}', [UserProductController::class, 'showByCategory'])->name('products.category');
Route::get('/produk/{product:slug}', [UserProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    // Registrasi
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [UserAuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [UserAuthenticatedSessionController::class, 'store']);
    
    // Lupa Password
    Route::get('lupa-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('lupa-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    
    // Reset Password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Logout
Route::middleware('auth')->group(function () {
    Route::post('logout', [UserAuthenticatedSessionController::class, 'destroy'])->name('logout');
});
