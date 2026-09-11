<?php

use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Owner\CategoryController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\ProductController;
use App\Http\Controllers\Owner\TransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Owner Routes (Requires Login)
Route::middleware(['auth', 'verified'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.update-status');
});

// Customer Routes (Public / No Login)
Route::get('/checkout/{product}', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/{product}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/status/{uuid}', [CheckoutController::class, 'orderStatus'])->name('order.status');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
