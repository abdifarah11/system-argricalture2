<?php

use App\Http\Controllers\Api\EcommerceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CropController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/ecommerce/categories', [EcommerceController::class, 'index']);
Route::post('/pay', [PaymentController::class, 'send']);

Route::get('/waafi-payment', [PaymentController::class, 'payNow'])->name('waafi.payment');
Route::get('/search-crops', [CropController::class, 'search'])->name('crops.search');
