<?php

use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group( function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Shop Routes
    Route::prefix('shops')->name('shops.')->group(function () {
        Route::resource('/', ShopController::class)->parameter('', 'shop');
    });
    // Shop Items Routes
    Route::prefix('shop-items')->name('shop-items.')->group(function () {
        Route::resource('/', ShopItemController::class)->parameter('', 'shop-items');
    });
    // Order Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::resource('/', OrderController::class)->parameter('', 'order');
    });
    // Order Items Routes
    Route::prefix('order-items/{order}')->name('order-items.')->group(function () {
        Route::resource('/', OrderItemController::class)->parameter('', 'order-items');
    });
});

require __DIR__.'/auth.php';
