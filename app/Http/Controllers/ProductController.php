<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function shop()
    {
        try {
            $products = Cache::remember('watches_products', 3600, function () {
                Log::info('Fetching all products from DummyJSON API...');
                $response = Http::timeout(30)->get('https://dummyjson.com/products?limit=100');

                if ($response->failed()) {
                    Log::error('Failed to fetch all products', ['status' => $response->status()]);
                    return collect();
                }

                $data = $response->json();

                if (!isset($data['products']) || !is_array($data['products'])) {
                    Log::warning('API response missing products key or products is not array.');
                    return collect();
                }

                $allProducts = collect($data['products']);
                Log::info('Total products fetched: ' . $allProducts->count());

                // Filter products by 'watch' keyword in title or category (case insensitive)
                $watches = $allProducts->filter(function ($product) {
                    $title = strtolower($product['title'] ?? '');
                    $category = strtolower($product['category'] ?? '');
                    return str_contains($title, 'watch') || str_contains($category, 'watch');
                });

                Log::info('Watches filtered count: ' . $watches->count());

                $validProducts = collect();

                foreach ($watches as $product) {
                    $validated = $this->validateAndTransformProduct($product);
                    if ($validated) {
                        $validProducts->push($validated);
                    }
                }

                Log::info('Valid products count after validation: ' . $validProducts->count());

                // Return up to 50 watches
                return $validProducts->take(50);
            });

            return view('shop', ['products' => $products]);

        } catch (\Exception $e) {
            Log::error('Error in shop method: ' . $e->getMessage());
            return view('shop', ['products' => collect()]);
        }
    }

    public function product($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                abort(404, "Invalid product ID");
            }

            $product = Cache::remember("product_{$id}", 3600, function () use ($id) {
                $response = Http::timeout(30)->get("https://dummyjson.com/products/{$id}");

                if ($response->failed()) {
                    return null;
                }

                return $this->validateAndTransformProduct($response->json());
            });

            if (!$product) {
                abort(404, "Product not found");
            }

            return view('product', ['product' => $product]);

        } catch (\Exception $e) {
            Log::error('Error in product method: ' . $e->getMessage());
            abort(404, "Product not found");
        }
    }

    private function validateAndTransformProduct($productData)
    {
        if (!is_array($productData)) {
            return null;
        }

        $reviewsCount = 0;
        if (isset($productData['reviews'])) {
            if (is_numeric($productData['reviews'])) {
                $reviewsCount = (int)$productData['reviews'];
            } elseif (is_array($productData['reviews'])) {
                $reviewsCount = count($productData['reviews']);
            }
        }

        $validated = [
            'id' => isset($productData['id']) ? (int)$productData['id'] : null,
            'title' => isset($productData['title']) ? (string)$productData['title'] : 'No Title',
            'price' => isset($productData['price']) ? (float)$productData['price'] : 0.0,
            'thumbnail' => isset($productData['thumbnail']) ? (string)$productData['thumbnail'] : '',
            'description' => isset($productData['description']) ? (string)$productData['description'] : 'No description available.',
            'rating' => isset($productData['rating']) ? (float)$productData['rating'] : 0.0,
            'brand' => isset($productData['brand']) ? (string)$productData['brand'] : 'Unknown Brand',
            'reviews' => $reviewsCount,
        ];

        if (!$validated['id'] || !$validated['title']) {
            return null;
        }

        return $validated;
    }
}
