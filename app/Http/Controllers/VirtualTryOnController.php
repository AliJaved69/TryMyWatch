<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class VirtualTryOnController extends Controller
{
    /**
     * Real-time AR Try-On (WebXR / Camera Stream)
     */
    public function ar($id)
    {
        $product = Product::findOrFail($id);
        
        // Fall back to a default local watch model if none is assigned in the database
        if (!$product->model_3d) {
            $product->model_3d = 'products/models/classic-watch.glb';
        }

        return view('virtual-try-on.ar', compact('product'));
    }

    /**
     * Static Image Upload Try-On (MediaPipe on Image)
     */
    public function showUploadForm($id)
    {
        $product = Product::findOrFail($id);
        return view('virtual-try-on.upload', compact('product'));
    }
}
