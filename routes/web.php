<?php

use App\Http\Controllers\Auth\TwoFaController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\Admin\AuditTrails;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Roles\Edit;
use App\Livewire\Admin\Roles\Roles;
use App\Livewire\Admin\Settings\Settings;
use App\Livewire\Admin\Users\EditUser;
use App\Livewire\Admin\Users\ShowUser;
use App\Livewire\Admin\Users\Users;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle);
});

Route::get('/', WelcomeController::class);

Route::prefix(config('admintw.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('2fa', [TwoFaController::class, 'index'])->name('admin.2fa');
    Route::post('2fa', [TwoFaController::class, 'update'])->name('admin.2fa.update');
    Route::get('2fa-setup', [TwoFaController::class, 'setup'])->name('admin.2fa-setup');
    Route::post('2fa-setup', [TwoFaController::class, 'setupUpdate'])->name('admin.2fa-setup.update');

    Route::prefix('settings')->group(function () {
        Route::get('audit-trails', AuditTrails::class)->name('admin.settings.audit-trails.index');
        Route::get('system-settings', Settings::class)->name('admin.settings');
        Route::get('roles', Roles::class)->name('admin.settings.roles.index');
        Route::get('roles/{role}/edit', Edit::class)->name('admin.settings.roles.edit');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', Users::class)->name('admin.users.index');
        Route::get('{user}/edit', EditUser::class)->name('admin.users.edit');
        Route::get('{user}', ShowUser::class)->name('admin.users.show');
    });

    Route::prefix('products')->group(function () {
        Route::get('list-categories', App\Livewire\Admin\ProductCategories\ProductCategoryLive::class)->name('admin.products.list-categories');
        Route::post('add-categories', App\Livewire\Admin\ProductCategories\ProductCategoryLive::class)->name('admin.products.add-categories');
        Route::post('delete-categories', App\Livewire\Admin\ProductCategories\ProductCategoryLive::class)->name('admin.products.delete-categories');
        Route::get('edit-categories', App\Livewire\Admin\ProductCategories\ProductCategoryLive::class)->name('admin.products.edit-categories');
        Route::post('update-categories', App\Livewire\Admin\ProductCategories\ProductCategoryLive::class)->name('admin.products.update-categories');
        Route::get('{productCategory}/subcategories', App\Livewire\Admin\ProductCategories\Subcategories::class)->name('admin.products.subcategories');
        Route::post('{productCategory}/update-subcategories', [App\Livewire\Admin\ProductCategories\Subcategories::class , 'updateSubcategories'])->name('admin.products.update-subcategories');

        Route::get('list-products', App\Livewire\Admin\Products\ProductLive::class)->name('admin.products.list-products');
        Route::post('add-product', [App\Livewire\Admin\Products\ProductLive::class, 'addProduct'])->name('admin.products.add-product');
        Route::post('delete-product', App\Livewire\Admin\Products\ProductLive::class)->name('admin.products.delete-product');
        Route::get('{product}/edit-product', App\Livewire\Admin\Products\ProductEdit::class)->name('admin.products.edit-product');
        Route::post('{product}/update-product', [App\Livewire\Admin\Products\ProductEdit::class, 'updateProduct'])->name('admin.products.update-product');
        Route::post('{product}/gallery', [App\Livewire\Admin\Products\ProductEdit::class, 'gallery'])->name('admin.products.update-gallery');

        Route::get('{product}/comments', App\Livewire\Admin\Products\Comments::class)->name('admin.products.comments');
        Route::post('{comment}/update', [App\Livewire\Admin\Products\Comments::class, 'updateComment'])->name('admin.products.update');
    });
});

require __DIR__.'/auth.php';
