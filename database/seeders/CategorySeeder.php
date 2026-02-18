<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Mens Watches', 'Womens Watches', 'Kids Watches', 'Luxury Watches', 'Smart Watches'];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category)],
                [
                    'name' => $category,
                    'description' => "Best collection of $category",
                    'image' => 'https://dummyjson.com/image/100x100?text=' . urlencode($category),
                ]
            );
        }
    }
}
