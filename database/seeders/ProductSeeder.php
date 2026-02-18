<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = \Illuminate\Support\Facades\Http::get('https://dummyjson.com/products?limit=100');
        
        if ($response->successful()) {
            $products = $response->json()['products'];
            
            foreach ($products as $product) {
                // Filter for watches
                if (str_contains(strtolower($product['title']), 'watch') || str_contains(strtolower($product['category']), 'watch')) {
                     \App\Models\Product::updateOrCreate(
                        ['title' => $product['title']],
                        [
                            'description' => $product['description'],
                            'price' => $product['price'],
                            'thumbnail' => $product['thumbnail'],
                            'category' => $product['category'],
                            'brand' => $product['brand'] ?? 'Unknown',
                            'rating' => $product['rating'],
                        ]
                    );
                }
            }
        }
    }
}
