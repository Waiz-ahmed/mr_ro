<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DailySaleController;
use App\Http\Controllers\CreditCustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ShopController;

// Redirect root to dashboard
Route::get('/', fn() => redirect('/dashboard'));

// Dashboard page (POS layout)
Route::get('/dashboard', fn() => view('home'))->middleware(['auth'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // ========================
    // Profile Routes
    // ========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========================
    // POS Modules
    // ========================
    Route::resource('customers', CustomerController::class);
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

    Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');

    Route::resource('sales', DailySaleController::class);
    Route::get('sales/report/{type}', [DailySaleController::class, 'report'])->name('sales.report'); // PDF Reports

    Route::resource('credits', CreditCustomerController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::get('/credits/invoice/{customer}', [CreditCustomerController::class, 'generateInvoice'])->name('credits.invoice');
    // Current card view for main navbar
    Route::get('/my_shops', [ShopController::class, 'myShops'])->name('shops.cards');

// New settings page for managing shops
    Route::get('/settings/shops', [ShopController::class, 'settingsShops'])->name('shops.settings');

// Still using same store method
    Route::post('/my_shops', [ShopController::class, 'store'])->name('shops.cards.store');
    Route::get('/shops/{shop}/pos', [DailySaleController::class, 'shopPosPage'])->name('shops.pos');
    // Route::get('/shops/{shop}/pos', [DailySaleController::class, 'pos'])->name('shops.pos');



});

// Include Breeze default auth routes (login, register, etc.)
require __DIR__.'/auth.php';
