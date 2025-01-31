<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        // Prepare the query to get all products with category.
        $products = Product::query()->with('category');

        // Sort the products.
        if ($request->sort) {
            // Check if the sort value is valid.
            if(!in_array($request->sort, ['asc', 'desc'])) {
                return response()->json(['message' => 'Invalid sort value.'], 400);
            }

            // Sort the products by price.
            {{ $request->sort === 'desc' ?  $products = $products->orderByDesc('price') : $products = $products->orderBy('price'); }}
        } else {
            // Default sort the products by price in ascending order.
            $products = $products->orderBy('price');
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

        // Check if there are no products.
        if($products->count() === 0) {
            return response()->json(['message' => 'No products found.'], 404);
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
