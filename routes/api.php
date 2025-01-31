<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Product routes.
 */

// Get products. URL: /api/products
Route::any('/products', [ProductController::class, 'getProducts']);

// Store a new product. URL: /api/products/store
Route::post('/products/store', [ProductController::class, 'store']);

// Update a product. URL: /api/products/update
Route::post('/products/update', [ProductController::class, 'update']);

// Delete a product. URL: /api/products/delete
Route::post('/products/delete', [ProductController::class, 'destroy']);
