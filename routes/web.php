<?php
  use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ControllerSearch;
    use App\Http\Controllers\CropController;
use App\Http\Controllers\CropTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PriceHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminPasswordController;

    // routes/web.php




// Public home page
Route::get('/', function () {
    return view('auth.login');
});

// Homepage after login
Route::get('/home', [HomeController::class, 'index'])->name('homepage');

// Dashboard with auth & email verification
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
// All authenticated routes
Route::middleware(['auth'])->group(function () {




    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/'); // Or wherever you want to redirect after logout
    })->name('logout');


    

    // === Admin Only ===
      Route::middleware(['role:admin'])->prefix('users')->group(function () {
    // User Management
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/get-data', [UserController::class, 'getData'])->name('users.get.data');

    // ✅ Change Password
    Route::get('/{id}/changepassword', [UserController::class, 'showChangePasswordForm'])->name('users.changePasswordForm');
    Route::post('/{id}/changepassword', [UserController::class, 'changepassword'])->name('users.changePassword');



});




Route::prefix('settings')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/create', [SettingController::class, 'create'])->name('settings.create');
    Route::post('/store', [SettingController::class, 'store'])->name('settings.store');
    Route::get('/{id}/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/{id}/update', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('/{id}/delete', [SettingController::class, 'destroy'])->name('settings.destroy');
});

          
        // Crop types management
        Route::prefix('crop_types')->group(function () {
            Route::get('/create', [CropTypeController::class, 'create'])->name('crop_types.create');
            Route::post('/store', [CropTypeController::class, 'store'])->name('crop_types.store');
            Route::get('crop_types/{id}/edit', [CropTypeController::class, 'edit'])->name('crop_types.edit');
            Route::put('{id}/update', [CropTypeController::class, 'update'])->name('crop_types.update');
            Route::delete('{id}/delete', [CropTypeController::class, 'destroy'])->name('crop_types.delete');




            
        });

        

        // Crops management
        Route::prefix('crops')->group(function () {
            Route::get('/create', [CropController::class, 'create'])->name('crops.create');
            Route::post('/store', [CropController::class, 'store'])->name('crops.store');
            Route::get('crops/{id}/edit', [CropController::class, 'edit'])->name('crops.edit');
            Route::put('{id}/update', [CropController::class, 'update'])->name('crops.update');
            Route::delete('{id}/delete', [CropController::class, 'destroy'])->name('crops.delete');
            
    
    Route::get('/search', [CropController::class, 'search'])->name('crops.search');

        });

        // Payment methods management
        Route::prefix('payment_methods')->group(function () {
            Route::get('/', action: [PaymentMethodController::class, 'index'])->name('payment_methods.index');
            Route::get('/create', [PaymentMethodController::class, 'create'])->name('payment_methods.create');
            Route::post('/store', [PaymentMethodController::class, 'store'])->name('payment_methods.store');
            Route::get('crops/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment_methods.edit');
            Route::put('{id}/update', [PaymentMethodController::class, 'update'])->name('payment_methods.update');
            Route::delete('{id}/delete', [PaymentMethodController::class, 'destroy'])->name('payment_methods.delete');
        });
    });

    // === Market Officer + Admin ===
    Route::middleware(['role:admin,market_officer'])->group(function () {

        // Orders management
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('/{order}', [OrderController::class, 'update'])->name('update');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        });

        // Transactions management
        Route::prefix('transactions')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
            Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
            Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
            Route::get('crops/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
            Route::get('{id}/show', [TransactionController::class, 'show'])->name('transactions.show');
            Route::put('{id}/update', [PaymentMethodController::class, 'update'])->name('transactions.update');
            Route::delete('{id}/delete', [TransactionController::class, 'destroy'])->name('transactions.delete');
        });

        // Price History management
        Route::prefix('PriceHistory')->group(function () {
            Route::get('/create', [PriceHistoryController::class, 'create'])->name('PriceHistory.create');
            Route::post('/store', [PriceHistoryController::class, 'store'])->name('PriceHistory.store');
            Route::get('crops/{id}/edit', [PriceHistoryController::class, 'edit'])->name('PriceHistory.edit');
            Route::put('{id}/update', [PriceHistoryController::class, 'update'])->name('PriceHistory.update');
            Route::delete('{id}/delete', [PriceHistoryController::class, 'destroy'])->name('PriceHistory.delete');
        });
    });

    // === All Roles (Admin, Market Officer, General) Read-Only Access ===
    Route::middleware(['role:admin,market_officer,general'])->group(function () {

        // Crop Types read-only
        Route::prefix('crop_types')->group(function () {
            Route::get('/', [CropTypeController::class, 'index'])->name('crop_types.index');
            Route::get('{id}/show', [CropTypeController::class, 'show'])->name('crop_types.show');
        });

        // Crops read-only
        Route::prefix('crops')->group(function () {
            Route::get('/', [CropController::class, 'index'])->name('crops.index');
            Route::get('{id}/show', [CropController::class, 'show'])->name('crops.show');
        });

        // Price History read-only
        Route::prefix('PriceHistory')->group(function () {
            Route::get('/', [PriceHistoryController::class, 'index'])->name('PriceHistory.index');
            Route::get('{id}/show', [PriceHistoryController::class, 'show'])->name('PriceHistory.show');

            Route::get('/price-history/report', [PriceHistoryController::class, 'report'])->name('price_history.report');

        });
    });

    // Profile routes accessible by all authenticated users
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

Route::get('/chackout', [CartController::class, 'gocToCheckout'])->name('chackout.view');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Order Routes
Route::middleware(['role:customer'])->prefix('order')->group(function () {
    Route::post('/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/orders', [OrderController::class, 'viewOrder'])->name('order.view');
});



require __DIR__ . '/auth.php';
