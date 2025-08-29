<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/p/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::post('/orders', [OrderController::class, 'store'])->middleware('throttle:10,1')->name('orders.store');

Route::view('/thanks', 'thanks')->name('thanks');

// Minimal authentication routes so Filament ->login() works when Breeze/etc. isn't installed
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

