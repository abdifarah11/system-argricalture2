<?php

use App\Http\Controllers\CropController;
use App\Http\Controllers\CropTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('{id}/delete', [UserController::class, 'destroy'])->name('users.delete');

        Route::get('/get-data', [UserController::class, 'getData'])->name('users.get.data');


    });
    Route::group(['prefix' => 'crop_types'], function () {
        Route::get('/', [CropTypeController::class, 'index'])->name('crop_types.index');
        Route::get('/create', [CropTypeController::class, 'create'])->name('crop_types.create');
        Route::post('/store', [CropTypeController::class, 'store'])->name('crop_types.store');
        Route::get('crop_types/{id}/edit', [CropTypeController::class, 'edit'])->name('crop_types.edit');
        Route::get('{id}/show', [CropTypeController::class, 'show'])->name('crop_types.show');
        Route::put('{id}/update', [CropTypeController::class, 'update'])->name('crop_types.update');
        Route::delete('{id}/delete', [CropTypeController::class, 'destroy'])->name('crop_types.delete');

    });
    Route::group(['prefix' => 'crops'], function () {
        Route::get('/', [CropController::class, 'index'])->name('crops.index');
        Route::get('/create', [CropController::class, 'create'])->name('crops.create');
        Route::post('/store', [CropController::class, 'store'])->name('crops.store');
        Route::get('crops/{id}/edit', [CropController::class, 'edit'])->name('crops.edit');
        Route::get('{id}/show', [CropController::class, 'show'])->name('crops.show');
        Route::put('{id}/update', [CropController::class, 'update'])->name('crops.update');
        Route::delete('{id}/delete', [CropController::class, 'destroy'])->name('crops.delete');

    });

    Route::group(['prefix' => 'Orders', 'as' => 'orders.'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    });


  
});

require __DIR__ . '/auth.php';
