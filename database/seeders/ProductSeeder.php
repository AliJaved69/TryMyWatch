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
        $demoWatches = [
            [
                'title' => 'Omega Speedmaster Classic',
                'description' => 'A timeless masterpiece featuring a stainless steel case, black dial, and chronometer functions. Perfect for both formal and casual settings.',
                'price' => 5200.00,
                'thumbnail' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&q=80&w=600',
                'category' => 'Luxury Watches',
                'brand' => 'Omega',
                'rating' => 4.9,
                'model_3d' => 'https://asset-samples.threepipe.org/demos/classic-watch.glb',
                'gallery' => [
                    'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&q=80&w=600',
                    'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&q=80&w=600'
                ]
            ],
            [
                'title' => 'Tag Heuer Chronograph Watch',
                'description' => 'Engineering precision meets luxury design. This chronograph features a detailed mechanical dial, sapphire crystal, and premium leather strap.',
                'price' => 3100.00,
                'thumbnail' => 'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&q=80&w=600',
                'category' => 'Luxury Watches',
                'brand' => 'Tag Heuer',
                'rating' => 4.8,
                'model_3d' => 'https://cdn.jsdelivr.net/gh/KhronosGroup/glTF-Sample-Assets@main/Models/ChronographWatch/glTF-Binary/ChronographWatch.glb',
                'gallery' => [
                    'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&q=80&w=600',
                    'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&q=80&w=600'
                ]
            ],
            [
                'title' => 'Minimalist Gold Wristwatch',
                'description' => 'Sleek gold-plated case with a white minimalist face and genuine brown leather strap. Express your style with subtle elegance.',
                'price' => 1850.00,
                'thumbnail' => 'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&q=80&w=600',
                'category' => 'Luxury Watches',
                'brand' => 'Cartier',
                'rating' => 4.7,
                'model_3d' => 'https://cdn.glitch.global/d29f98b4-ddd1-4589-8b66-e2446690e697/watch.glb?v=1645016979219',
                'gallery' => [
                    'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&q=80&w=600'
                ]
            ]
        ];

        foreach ($demoWatches as $watchData) {
            $thumbnailUrl = $watchData['thumbnail'];
            $modelUrl = $watchData['model_3d'];

            $localThumbnail = $thumbnailUrl;
            $localModel = $modelUrl;

            // 1. Download and store thumbnail image locally
            try {
                $imgName = basename(parse_url($thumbnailUrl, PHP_URL_PATH));
                $imgPath = 'products/images/' . $imgName;
                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath)) {
                    $response = \Illuminate\Support\Facades\Http::get($thumbnailUrl);
                    if ($response->successful()) {
                        \Illuminate\Support\Facades\Storage::disk('public')->put($imgPath, $response->body());
                    }
                }
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath)) {
                    $localThumbnail = $imgPath;
                }
            } catch (\Exception $e) {
                // Keep external fallback URL
            }

            // 2. Download and store 3D GLB model locally
            try {
                $modelName = basename(parse_url($modelUrl, PHP_URL_PATH));
                $modelPath = 'products/models/' . $modelName;
                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($modelPath)) {
                    $response = \Illuminate\Support\Facades\Http::get($modelUrl);
                    if ($response->successful()) {
                        \Illuminate\Support\Facades\Storage::disk('public')->put($modelPath, $response->body());
                    }
                }
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($modelPath)) {
                    $localModel = $modelPath;
                }
            } catch (\Exception $e) {
                // Keep external fallback URL
            }

            // 3. Localize gallery images
            $localGallery = [];
            foreach ($watchData['gallery'] as $galleryUrl) {
                $galLocal = $galleryUrl;
                try {
                    $galName = basename(parse_url($galleryUrl, PHP_URL_PATH));
                    $galPath = 'products/gallery/' . $galName;
                    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($galPath)) {
                        $response = \Illuminate\Support\Facades\Http::get($galleryUrl);
                        if ($response->successful()) {
                            \Illuminate\Support\Facades\Storage::disk('public')->put($galPath, $response->body());
                        }
                    }
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($galPath)) {
                        $galLocal = $galPath;
                    }
                } catch (\Exception $e) {
                }
                $localGallery[] = $galLocal;
            }

            \App\Models\Product::updateOrCreate(
                ['title' => $watchData['title']],
                [
                    'description' => $watchData['description'],
                    'price' => $watchData['price'],
                    'thumbnail' => $localThumbnail,
                    'category' => $watchData['category'],
                    'brand' => $watchData['brand'],
                    'rating' => $watchData['rating'],
                    'model_3d' => $localModel,
                    'gallery' => $localGallery,
                ]
            );
        }

        try {
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
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Failed to fetch dummyjson products: " . $e->getMessage());
        }
    }
}
