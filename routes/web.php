<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\CropTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PriceHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;


// Route::get('/home', function () {
//     return view('website.home');
// })->name('home');
////
Route::get('/home', [HomeController::class, 'index'])->name('homepage');

// Middleware


// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index']);
// });

// Route::middleware(['auth', 'role:market_officer'])->group(function () {
//     Route::get('/officer/panel', [MarketOfficerController::class, 'index']);
// });

// Route::middleware(['auth', 'role:admin,market_officer'])->group(function () {
//     Route::get('/shared/section', [SharedController::class, 'index']);
// });



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

        Route::group(['prefix' => 'payment_methods'], function () {
        Route::get('/', [PaymentMethodController::class, 'index'])->name('payment_methods.index');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('payment_methods.create');
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('payment_methods.store');
        Route::get('crops/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment_methods.edit');
        Route::get('{id}/show', [PaymentMethodController::class, 'show'])->name('payment_methods.show');
        Route::put('{id}/update', [PaymentMethodController::class, 'update'])->name('payment_methods.update');
        Route::delete('{id}/delete', [PaymentMethodController::class, 'destroy'])->name('payment_methods.delete');

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




       Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('crops/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::get('{id}/show', [TransactionController::class, 'show'])->name('transactions.show');
        Route::put('{id}/update', [PaymentMethodController::class, 'update'])->name('transactions.update');
        Route::delete('{id}/delete', [TransactionController::class, 'destroy'])->name('transactions.delete');

    });

       Route::group(['prefix' => 'PriceHistory'], function () {
        Route::get('/', [PriceHistoryController::class, 'index'])->name('PriceHistory.index');
        Route::get('/create', [PriceHistoryController::class, 'create'])->name('PriceHistory.create');
        Route::post('/store', [PriceHistoryController::class, 'store'])->name('PriceHistory.store');
        Route::get('crops/{id}/edit', [PriceHistoryController::class, 'edit'])->name('PriceHistory.edit');
        Route::get('{id}/show', [PriceHistoryController::class, 'show'])->name('PriceHistory.show');
        Route::put('{id}/update', [PriceHistoryController::class, 'update'])->name('PriceHistory.update');
        Route::delete('{id}/delete', [PriceHistoryController::class, 'destroy'])->name('PriceHistory.delete');

    });




  

  
});

require __DIR__ . '/auth.php';
