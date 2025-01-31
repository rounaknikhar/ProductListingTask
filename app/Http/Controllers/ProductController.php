<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    /**
     * Get the products with filter.
     */
    public function getProducts(Request $request): JsonResponse | LengthAwarePaginator
    {
        // Get all products by default sort by price ascending.
        $products = Product::query()->orderBy('price', 'ASC', true);

        // Sort the products.
        if ($request->sort) {
            $products = $products->orderBy('price', $request->sort, true);
        }

        if ($request->category) {
            // Find the category by name.
            $category = Category::where('name', 'like', $request->category)->first();

            // Check if the category exists.
            if (!$category) {
                return response()->json(['message' => 'Category not found.'], 404);
            } else {
                // Filter the products by category.
                $products = $products->where('category_id', $category->id);
            }
        }

        // Search for products.
        if ($request->search) {
            $products = Product::where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Paginate the products.
        $productsData = $products->paginate(10);

        // Return the products.
        return $productsData;
    }

    /**
     * Get categories.
     */
    public function getCategories(): JsonResponse
    {
        // Get all categories.
        $categories = Category::all();

        // Return the categories.
        return response()->json($categories);
    }
}
