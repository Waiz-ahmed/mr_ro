<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DailySaleController;
use App\Http\Controllers\CreditCustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShopController;

// Redirect root to dashboard
Route::get('/', fn() => redirect('/dashboard'));

// Dashboard page (POS layout) - accessible to all authenticated users
Route::get('/dashboard', fn() => view('home'))->middleware(['auth'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::middleware(['permission:manage-permissions'])->prefix('admin')->name('admin.')->group(function () {
        // Permission dashboard
        Route::get('/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index');
        
        // Role management
        Route::post('/roles/create', [App\Http\Controllers\Admin\PermissionController::class, 'createRole'])->name('roles.create');
        Route::post('/roles/{role}/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'assignToRole'])->name('roles.permissions.assign');
        Route::get('/roles/{role}/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'getRolePermissions'])->name('roles.permissions.get');
        Route::delete('/roles/{role}', [App\Http\Controllers\Admin\PermissionController::class, 'deleteRole'])->name('roles.delete');
        
        // Permission management
        Route::post('/permissions/create', [App\Http\Controllers\Admin\PermissionController::class, 'createPermission'])->name('permissions.create');
        Route::get('/permissions/{permission}/edit', [App\Http\Controllers\Admin\PermissionController::class, 'editPermission'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [App\Http\Controllers\Admin\PermissionController::class, 'updatePermission'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [App\Http\Controllers\Admin\PermissionController::class, 'deletePermission'])->name('permissions.delete');
        
        // User management
        Route::get('/users', [App\Http\Controllers\Admin\PermissionController::class, 'users'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\Admin\PermissionController::class, 'createUser'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\Admin\PermissionController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\PermissionController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\Admin\PermissionController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\PermissionController::class, 'deleteUser'])->name('users.delete');
        
        // User role assignment
        Route::post('/users/{user}/roles', [App\Http\Controllers\Admin\PermissionController::class, 'assignToUser'])->name('users.roles.assign');
        Route::get('/users/{user}/roles', [App\Http\Controllers\Admin\PermissionController::class, 'getUserRoles'])->name('users.roles.get');
        
        // AJAX routes
        Route::get('/menus/{menu}/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'getMenuPermissions'])->name('menus.permissions');
        // Route::get('/roles/{role}/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'getRolePermissions'])->name('roles.permissions.get');
        Route::post('/roles/{role}/permissions/sync', [App\Http\Controllers\Admin\PermissionController::class, 'syncRolePermissions'])->name('roles.permissions.sync');
        
        // Save all permissions from matrix
        Route::post('/permissions/save-matrix', [App\Http\Controllers\Admin\PermissionController::class, 'saveMatrix'])->name('permissions.save.matrix');
    });

    // ========================
    // Profile Routes (accessible to all)
    // ========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========================
    // POS Modules with Permissions
    // ========================
    
    // Customers Module
    Route::middleware(['permission:view-customers'])->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });
    
    Route::middleware(['permission:create-customer'])->group(function () {
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');
    });
    
    Route::middleware(['permission:edit-customer'])->group(function () {
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::patch('/customers/{customer}', [CustomerController::class, 'update']);
    });
    
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('permission:delete-customer')
        ->name('customers.destroy');

    // Sales/Orders Module
    Route::middleware(['permission:view-orders'])->group(function () {
        Route::get('/sales', [DailySaleController::class, 'allSales'])->name('sales.index');
        Route::get('/sales/{sale}', [DailySaleController::class, 'show'])->name('sales.show');
        Route::get('/daily-sales/drafts', [DailySaleController::class, 'drafts'])->name('sales.drafts');
    });
    
    Route::middleware(['permission:create-order'])->group(function () {
        Route::get('/sales/create', [DailySaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [DailySaleController::class, 'store'])->name('sales.store');
        Route::get('/shops/{shop}/pos', [DailySaleController::class, 'shopPosPage'])->name('shops.pos');
    });
    
    Route::middleware(['permission:edit-order'])->group(function () {
        Route::get('/sales/{sale}/edit', [DailySaleController::class, 'edit'])->name('sales.edit');
        Route::put('/sales/{sale}', [DailySaleController::class, 'update'])->name('sales.update');
        Route::post('/daily-sales/{id}/finalize', [DailySaleController::class, 'finalize'])->name('sales.finalize');
        Route::post('/sales/finalize/{id}', [DailySaleController::class, 'finalizeSale'])->name('sales.finalize');
    });
    
    Route::delete('/sales/{sale}', [DailySaleController::class, 'destroy'])
        ->middleware('permission:delete-order')
        ->name('sales.destroy');

    // Credit Customers Module
    Route::middleware(['permission:view-credits'])->group(function () {
        Route::get('/credits', [CreditCustomerController::class, 'index'])->name('credits.index');
        Route::get('/credits/{credit}', [CreditCustomerController::class, 'show'])->name('credits.show');
        Route::get('/credits/invoice/{customer}', [CreditCustomerController::class, 'generateInvoice'])->name('credits.invoice');
    });
    
    Route::middleware(['permission:manage-credits'])->group(function () {
        Route::get('/credits/create', [CreditCustomerController::class, 'create'])->name('credits.create');
        Route::post('/credits', [CreditCustomerController::class, 'store'])->name('credits.store');
        Route::get('/credits/{credit}/edit', [CreditCustomerController::class, 'edit'])->name('credits.edit');
        Route::put('/credits/{credit}', [CreditCustomerController::class, 'update'])->name('credits.update');
        Route::delete('/credits/{credit}', [CreditCustomerController::class, 'destroy'])->name('credits.destroy');
    });

    // Payments Module
    Route::middleware(['permission:view-payments'])->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    });
    
    Route::middleware(['permission:manage-payments'])->group(function () {
        Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    });

    // Vendors Module (Admin only typically)
    Route::middleware(['permission:view-vendors'])->group(function () {
        Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
        Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
    });
    
    Route::middleware(['permission:manage-vendors'])->group(function () {
        Route::get('/vendors/create', [VendorController::class, 'create'])->name('vendors.create');
        Route::post('/vendors', [VendorController::class, 'store'])->name('vendors.store');
        Route::get('/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
        Route::put('/vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update');
        Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy');
    });

    // Expenses Module
    Route::middleware(['permission:view-expenses'])->group(function () {
        Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::get('/expenses/{expense}', [ExpenseController::class, 'show'])->name('expenses.show');
    });
    
    Route::middleware(['permission:manage-expenses'])->group(function () {
        Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    });

    // Shops Module
    Route::middleware(['permission:view-shops'])->group(function () {
        Route::get('/my_shops', [ShopController::class, 'myShops'])->name('shops.cards');
        Route::get('/settings/shops', [ShopController::class, 'settingsShops'])->name('shops.settings');
        Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');
    });
    
    Route::middleware(['permission:manage-shops'])->group(function () {
        Route::post('/my_shops', [ShopController::class, 'store'])->name('shops.cards.store');
        Route::get('/shops/{shop}/edit', [ShopController::class, 'edit'])->name('shops.edit');
        Route::put('/shops/{shop}', [ShopController::class, 'update'])->name('shops.update');
        Route::delete('/shops/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');
    });

    // Reports Module
    Route::middleware(['permission:view-reports'])->group(function () {
        Route::get('/sales/report/{type}', [DailySaleController::class, 'report'])->name('sales.report');
        // Add other report routes here
    });

    // Settings Module
    Route::middleware(['permission:view-settings'])->prefix('settings')->group(function () {
        Route::get('/general/{shopId?}', [SettingController::class, 'general'])->name('settings.general');
    });
    
    Route::middleware(['permission:manage-settings'])->prefix('settings')->group(function () {
        Route::post('/general/{shopId}', [SettingController::class, 'updateGeneral'])->name('settings.general.update');
    });

    // FBR Settings (nested under shops with specific permission)
    Route::middleware(['permission:manage-shops'])->group(function () {
        Route::get('/shops/{shop}/fbr/edit', [\App\Http\Controllers\FbrSettingController::class, 'edit'])
            ->name('shops.fbr.edit');
        Route::post('/shops/{shop}/fbr', [\App\Http\Controllers\FbrSettingController::class, 'storeOrUpdate'])
            ->name('shops.fbr.update');
    });

});

// Include Breeze default auth routes (login, register, etc.)
require __DIR__ . '/auth.php';