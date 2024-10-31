<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Protected PI Routes
Route::middleware('auth:sanctum')->group( function () {
    //
});
    
// Order Routes
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('search/{search}', [OrderController::class, 'ajaxSearch']);
});
// Shop Items Routes
Route::prefix('shop-items')->name('shop-items.')->group(function () {
    Route::get('search/{search}', [ShopItemController::class, 'ajaxSearch']);
});