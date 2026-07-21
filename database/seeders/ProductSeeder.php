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
        // Clear old products to ensure a clean catalog of 5 working watches
        \App\Models\Product::truncate();

        $demoWatches = [
            [
                'title' => 'Omega Speedmaster Steel',
                'description' => 'A premium steel chronometer watch featuring a polished metallic link bracelet, black rotating bezel, and highly detailed black face dial. Engineered for timeless style.',
                'price' => 5200.00,
                'thumbnail' => 'classic-watch.png',
                'category' => 'Luxury Watches',
                'brand' => 'Omega',
                'rating' => 4.9,
                'model_3d' => 'https://asset-samples.threepipe.org/demos/classic-watch.glb',
                'gallery' => [
                    'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&q=80&w=600'
                ]
            ],
            [
                'title' => 'Tag Heuer Chronograph Leather',
                'description' => 'Luxury chronograph watch featuring a genuine brown leather strap, silver tachymeter casing, and multi-dial stopwatch functions. Classical design meets modern engineering.',
                'price' => 3100.00,
                'thumbnail' => 'chronograph.png',
                'category' => 'Luxury Watches',
                'brand' => 'Tag Heuer',
                'rating' => 4.8,
                'model_3d' => 'https://cdn.jsdelivr.net/gh/KhronosGroup/glTF-Sample-Assets@main/Models/ChronographWatch/glTF-Binary/ChronographWatch.glb',
                'gallery' => [
                    'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&q=80&w=600'
                ]
            ],
            [
                'title' => 'Cartier Minimalist Gold',
                'description' => 'Sleek gold-plated case with a clean white minimalist face and genuine black leather strap. A subtle luxury watch designed for sophisticated settings.',
                'price' => 1850.00,
                'thumbnail' => 'cartier.png',
                'category' => 'Luxury Watches',
                'brand' => 'Cartier',
                'rating' => 4.7,
                'model_3d' => 'https://asset-samples.threepipe.org/demos/classic-watch.glb',
                'gallery' => [
                    'https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?auto=format&fit=crop&q=80&w=600'
                ]
            ],
            [
                'title' => 'Tissot Midnight Edition',
                'description' => 'A high-end luxury dark-themed chronograph watch with a matte black steel case, sapphire crystal, and black leather strap.',
                'price' => 2800.00,
                'thumbnail' => 'chronograph.png',
                'category' => 'Sport Watches',
                'brand' => 'Tissot',
                'rating' => 4.6,
                'model_3d' => 'https://cdn.jsdelivr.net/gh/KhronosGroup/glTF-Sample-Assets@main/Models/ChronographWatch/glTF-Binary/ChronographWatch.glb',
                'gallery' => [
                    'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&q=80&w=600'
                ]
            ],
            [
                'title' => 'Rolex Oyster Perpetual',
                'description' => 'A stunning luxury steel watch with a polished oyster link bracelet, clear dial face, and silver indices. The epitome of refined metal link aesthetics.',
                'price' => 6400.00,
                'thumbnail' => 'classic-watch.png',
                'category' => 'Luxury Watches',
                'brand' => 'Rolex',
                'rating' => 4.9,
                'model_3d' => 'https://asset-samples.threepipe.org/demos/classic-watch.glb',
                'gallery' => [
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&q=80&w=600'
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
    }
}
