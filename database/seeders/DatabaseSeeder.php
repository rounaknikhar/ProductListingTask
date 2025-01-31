<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Generate 10 categories.
        Category::factory(10)->create();

        // Generate 35 products.
        Product::factory(35)->create();
    }
}
