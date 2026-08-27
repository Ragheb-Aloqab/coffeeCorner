<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOfferController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSettingController;
use Illuminate\Support\Facades\Route;

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// ── Admin Auth Routes ──
Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // ── Protected Admin Routes ──
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('dashboard', [AdminDashboardController::class, 'index']);

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

        // Customers
        Route::get('customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('customers/{id}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');
        Route::delete('customers/{id}', [AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');

        // Categories
        Route::resource('categories', AdminCategoryController::class, ['as' => 'admin']);

        // Products
        Route::resource('products', AdminProductController::class, ['as' => 'admin']);

        // Offers
        Route::resource('offers', AdminOfferController::class, ['as' => 'admin'])->only(['index', 'create', 'store', 'destroy']);

        // Settings
        Route::get('settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
    });
});
