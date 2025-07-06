<?php


use Illuminate\Support\Facades\Route;

Route::post('/midtrans/notification', [\App\Http\Controllers\Customer\CheckoutController::class, 'notificationHandler']);
