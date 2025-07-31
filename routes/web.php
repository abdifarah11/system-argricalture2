<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    AdminController,
    AdminPasswordController,
    CartController,
    ControllerSearch,
    CropController,
    CropTypeController,
    DashboardController,
    HomeController,
    OrderController,
    PaymentMethodController,
    PriceHistoryController,
    ProfileController,
    ReportController,
    SettingController,
    TransactionController,
    UserController,
    Web3LoginController
};

// ========================
// 🌐 Public Routes (No Middleware)
// ========================
Route::get('/', fn() => view('auth.login'));
Route::get('/home', [HomeController::class, 'index'])->name('homepage');

// ✅ Web3 Login
Route::get('/web3-login', [Web3LoginController::class, 'showLogin'])->name('web3.login');
Route::post('/web3-login/verify', [Web3LoginController::class, 'verifySignature'])->name('web3.verify');
Route::post('/web3-logout', [Web3LoginController::class, 'logout'])->name('web3.logout');

// ========================
// 🔐 Auth + Web3 Protected Routes
// ========================
Route::middleware(['auth', 'check.web3'])->group(function () {

    // 🏠 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔓 Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // ========================
    // 🛡️ Admin Routes
    // ========================
    Route::middleware(['role:admin'])->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
        Route::get('/get-data', [UserController::class, 'getData'])->name('users.get.data');
        Route::get('/{id}/changepassword', [UserController::class, 'showChangePasswordForm'])->name('users.changePasswordForm');
        Route::post('/{id}/changepassword', [UserController::class, 'changepassword'])->name('users.changePassword');
    });

    // ⚙️ Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::get('/create', [SettingController::class, 'create'])->name('settings.create');
        Route::post('/store', [SettingController::class, 'store'])->name('settings.store');
        Route::get('/{id}/edit', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/{id}/update', [SettingController::class, 'update'])->name('settings.update');
        Route::delete('/{id}/delete', [SettingController::class, 'destroy'])->name('settings.destroy');
    });

    // 🌿 Crop Types
    Route::prefix('crop_types')->group(function () {
        Route::get('/', [CropTypeController::class, 'index'])->name('crop_types.index');
        Route::get('/{id}/show', [CropTypeController::class, 'show'])->name('crop_types.show');
        Route::get('/create', [CropTypeController::class, 'create'])->name('crop_types.create');
        Route::post('/store', [CropTypeController::class, 'store'])->name('crop_types.store');
        Route::get('/{id}/edit', [CropTypeController::class, 'edit'])->name('crop_types.edit');
        Route::put('/{id}/update', [CropTypeController::class, 'update'])->name('crop_types.update');
        Route::delete('/{id}/delete', [CropTypeController::class, 'destroy'])->name('crop_types.delete');
    });

    // 🌽 Crops
    Route::prefix('crops')->group(function () {
        Route::get('/', [CropController::class, 'index'])->name('crops.index');
        Route::get('/{id}/show', [CropController::class, 'show'])->name('crops.show');
        Route::get('/create', [CropController::class, 'create'])->name('crops.create');
        Route::post('/store', [CropController::class, 'store'])->name('crops.store');
        Route::get('/{id}/edit', [CropController::class, 'edit'])->name('crops.edit');
        Route::put('/{id}/update', [CropController::class, 'update'])->name('crops.update');
        Route::delete('/{id}/delete', [CropController::class, 'destroy'])->name('crops.delete');
        Route::get('/search', [CropController::class, 'search'])->name('crops.search');
    });

    // 💳 Payment Methods
    Route::prefix('payment_methods')->group(function () {
        Route::get('/', [PaymentMethodController::class, 'index'])->name('payment_methods.index');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('payment_methods.create');
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('payment_methods.store');
        Route::get('/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment_methods.edit');
        Route::put('/{id}/update', [PaymentMethodController::class, 'update'])->name('payment_methods.update');
        Route::delete('/{id}/delete', [PaymentMethodController::class, 'destroy'])->name('payment_methods.delete');
    });

    // 📦 Orders
    Route::middleware(['role:admin,market_officer'])->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    });

    // 💰 Transactions
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::get('/{id}/show', [TransactionController::class, 'show'])->name('transactions.show');
        Route::put('/{id}/update', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/{id}/delete', [TransactionController::class, 'destroy'])->name('transactions.delete');
    });

    // 📈 Reports
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/data', [ReportController::class, 'data'])->name('reports.data');
        Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export_pdf');
    });

    // 🧑 Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

  


});
  // 🛍️ Customer Routes
    Route::prefix('order')->group(function () {
        Route::post('/place', [OrderController::class, 'placeOrder'])->name('order.place');
        Route::get('/history', [OrderController::class, 'orderHistory'])->name('order.history');
        Route::get('/orders', [OrderController::class, 'viewOrder'])->name('order.view');
    });

    // 🛒 Cart
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'gocToCheckout'])->name('checkout.view');


// ✅ Breeze/Fortify/Auth routes
require __DIR__ . '/auth.php';
