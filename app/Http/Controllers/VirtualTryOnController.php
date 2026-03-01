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
        
        // Ensure we have a 3D model
        if (!$product->model_3d) {
            return redirect()->back()->with('error', 'This product does not have a 3D model yet.');
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
