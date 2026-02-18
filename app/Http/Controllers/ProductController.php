<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function shop()
    {
        $products = \App\Models\Product::limit(50)->get();
        return view('shop', ['products' => $products]);
    }

    public function product($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('product', ['product' => $product]);
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
