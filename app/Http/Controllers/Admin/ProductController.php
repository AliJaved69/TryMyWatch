<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category' => 'required',
            'brand' => 'nullable',
            // Increased limits to match WatchController
            'thumbnail' => 'required|image|max:10240', // 10MB
            'gallery.*' => 'nullable|image|max:10240', // 10MB
            // Use 'extensions' instead of 'mimes' for better compatibility with 3D files
            'model_3d' => 'nullable|file|extensions:glb,gltf,obj|max:102400', // 100MB
        ]);

        // Handle Thumbnail
        if ($request->hasFile('thumbnail')) {
            // Store relative path (e.g., "products/filename.jpg")
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        // Handle Gallery
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                // Store relative path
                $galleryPaths[] = $image->store('products/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        } else {
             $validated['gallery'] = [];
        }

        // Handle 3D Model
        if ($request->hasFile('model_3d')) {
            // Store relative path but explicitly force the original extension
            $extension = $request->file('model_3d')->getClientOriginalExtension();
            $filename = uniqid('model_') . '.' . $extension;
            $validated['model_3d'] = $request->file('model_3d')->storeAs('products/models', $filename, 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category' => 'required',
            'brand' => 'nullable',
            'thumbnail' => 'nullable|image|max:10240', // 10MB
            'gallery.*' => 'nullable|image|max:10240', // 10MB
            'model_3d' => 'nullable|file|extensions:glb,gltf,obj|max:102400', // 100MB
        ]);

        // Handle Thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        } else {
             unset($validated['thumbnail']); // Keep existing
        }

        // Handle Gallery
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        } else {
            unset($validated['gallery']); // Keep existing
        }

        // Handle 3D Model
        if ($request->hasFile('model_3d')) {
            $extension = $request->file('model_3d')->getClientOriginalExtension();
            $filename = uniqid('model_') . '.' . $extension;
            $validated['model_3d'] = $request->file('model_3d')->storeAs('products/models', $filename, 'public');
        } else {
             unset($validated['model_3d']); // Keep existing
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
