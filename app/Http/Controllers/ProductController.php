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
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request) : JsonResponse
    {
        // Validate the form fields.
        $validatedFormFields = $request->validated();

        // Create a new product.
        $product = Product::create($validatedFormFields);

        // Success check for product creation.
        if (!$product) {
            // Return an error.
            return response()->json(['message' => 'An error occurred.'], 500);
        }

        // Return the product.
        return response()->json(['message' => 'Product has been added successfully!', ['product' => $product]], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // Validate the form fields.
        $validatedFormFields = $request->validated();

        // Update the validated product.
        $product = $product->update($validatedFormFields);

        // Success check for product modification.
        if (!$product) {
            // Return an error.
            return response()->json(['message' => 'An error occurred.'], 500);
        }

        // Return the product.
        return response()->json(['message' => 'Product has updated successfully!', ['product' => $product]], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the product.
        $delete = $product->delete();

        // Success check for product deletion.
        if (!$delete) {
            // Return an error.
            return response()->json(['message' => 'An error occurred.'], 500);
        }

        // Return a success message.
        return response()->json(['message' => 'Product has been deleted successfully!'], 200);
    }
}
