<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Shop Routes
    Route::prefix('shops')->name('shops.')->group(function () {
        Route::resource('/', ShopController::class);
    });
    // Shop Routes
    Route::prefix('shop-items')->name('shop-items.')->group(function () {
        Route::resource('/', ShopItemController::class);
    });
});

require __DIR__.'/auth.php';
