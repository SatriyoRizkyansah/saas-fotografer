<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\StoreController;
use App\Http\Controllers\Owner\CategoryController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\OwnerManagementController;
use App\Http\Controllers\Owner\SettingsController;
use App\Http\Controllers\Owner\ProductController;
use App\Http\Controllers\Owner\TransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Super Admin Routes
Route::middleware(['auth', 'verified', 'is_super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/owners', [OwnerManagementController::class, 'index'])->name('owners.index');
    Route::post('/owners/{id}/toggle-subscription', [OwnerManagementController::class, 'toggleSubscription'])->name('owners.toggle-subscription');
    Route::post('/owners/{id}/set-expiration', [OwnerManagementController::class, 'setExpiration'])->name('owners.set-expiration');
});

// Owner Routes (Requires Login + Active Subscription)
Route::middleware(['auth', 'verified', 'check_subscription'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
    Route::get('/settings/generate-url', [SettingsController::class, 'generateStoreUrl'])->name('settings.generate-url');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::patch('/products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle-active');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.update-status');
});

// Customer Routes (Public / No Login)
Route::get('/checkout/{product}', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/{product}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/status/{uuid}', [CheckoutController::class, 'orderStatus'])->name('order.status');
Route::get('/store/{store_uuid}', [StoreController::class, 'show'])->name('storefront.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
