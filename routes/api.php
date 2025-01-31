<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/**
 * Product routes.
 */

// Get products. URL: /api/products
Route::any('/products', [ProductController::class, 'getProducts']);

// Get categories. URL: /api/categories
Route::get('/categories', [ProductController::class, 'getCategories'])->name('api.categories');
