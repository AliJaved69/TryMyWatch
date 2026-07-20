<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Watch;

class WatchSeeder extends Seeder
{
    public function run(): void
    {
        // Start clean with the 5 verified watches
        \App\Models\Watch::truncate();

        $watches = [
            [
                'id' => 1,
                'name' => 'Omega Speedmaster Steel',
                'price' => 5200.00,
                'image' => 'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&q=80&w=600',
                'glb_model' => 'https://asset-samples.threepipe.org/demos/classic-watch.glb'
            ],
            [
                'id' => 2,
                'name' => 'Tag Heuer Chronograph Leather',
                'price' => 3100.00,
                'image' => 'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&q=80&w=600',
                'glb_model' => 'https://cdn.jsdelivr.net/gh/KhronosGroup/glTF-Sample-Assets@main/Models/ChronographWatch/glTF-Binary/ChronographWatch.glb'
            ],
            [
                'id' => 3,
                'name' => 'Cartier Minimalist Gold',
                'price' => 1850.00,
                'image' => 'https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?auto=format&fit=crop&q=80&w=600',
                'glb_model' => 'https://cdn.glitch.global/d29f98b4-ddd1-4589-8b66-e2446690e697/watch.glb?v=1645016979219'
            ],
            [
                'id' => 4,
                'name' => 'Tissot Midnight Edition',
                'price' => 2800.00,
                'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&q=80&w=600',
                'glb_model' => 'https://cdn.jsdelivr.net/gh/KhronosGroup/glTF-Sample-Assets@main/Models/ChronographWatch/glTF-Binary/ChronographWatch.glb'
            ],
            [
                'id' => 5,
                'name' => 'Rolex Oyster Perpetual',
                'price' => 6400.00,
                'image' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&q=80&w=600',
                'glb_model' => 'https://asset-samples.threepipe.org/demos/classic-watch.glb'
            ]
        ];

        foreach ($watches as $watchData) {
            $imageUrl = $watchData['image'];
            $modelUrl = $watchData['glb_model'];

            $localImage = $imageUrl;
            $localModel = $modelUrl;

            // 1. Download and store image locally
            try {
                $imgName = basename(parse_url($imageUrl, PHP_URL_PATH));
                $imgPath = 'watches/' . $imgName;
                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath)) {
                    $response = \Illuminate\Support\Facades\Http::get($imageUrl);
                    if ($response->successful()) {
                        \Illuminate\Support\Facades\Storage::disk('public')->put($imgPath, $response->body());
                    }
                }
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath)) {
                    $localImage = $imgPath;
                }
            } catch (\Exception $e) {
            }

            // 2. Download and store model locally
            try {
                $modelName = basename(parse_url($modelUrl, PHP_URL_PATH));
                $modelPath = 'watches/' . $modelName;
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
            }

            Watch::updateOrCreate(
                ['id' => $watchData['id']],
                [
                    'name' => $watchData['name'],
                    'price' => $watchData['price'],
                    'image' => $localImage,
                    'glb_model' => $localModel,
                ]
            );
        }
    }
}
