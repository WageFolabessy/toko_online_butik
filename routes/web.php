<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController as UserProductController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

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

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [UserProductController::class, 'index'])->name('products.index');
Route::get('/kategori/{category:slug}', [UserProductController::class, 'showByCategory'])->name('products.category');
Route::get('/produk/{product:slug}', [UserProductController::class, 'show'])->name('products.show');
