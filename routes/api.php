<?php

use App\Http\Controllers\Api\StormController;
use Illuminate\Cache\RateLimiting\GlobalLimit;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('categories', [App\Http\Controllers\Api\StormController::class, 'categories'])->name('api.categories');
Route::get('all-products', [App\Http\Controllers\Api\StormController::class, 'allProducts'])->name('api.all-products');
Route::get('{category}/products', [App\Http\Controllers\Api\StormController::class, 'products'])->name('api.products');
Route::get('product/{product}', [App\Http\Controllers\Api\StormController::class, 'product'])->name('api.product');
Route::get('{product}/comments', [App\Http\Controllers\Api\StormController::class, 'comments'])->name('api.comments');
Route::post('new-comment', [App\Http\Controllers\Api\StormController::class, 'newComment'])->name('api.new-comment');
