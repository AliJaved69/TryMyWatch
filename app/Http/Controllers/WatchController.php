<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watch;
use Illuminate\Support\Str;

class WatchController extends Controller
{
    public function showForm()
    {
        return view('watch.form');
    }

    public function try($id=3)
    {
        $watch = Watch::findOrFail($id);
        return view('watch.try', compact('watch'));
    }

    public function store(Request $request)
    {
        // 1. VALIDATION
        // We use 'mimes:glb' for security, assuming the production environment (Linux)
        // has the php-fileinfo extension enabled.
        $request->validate([
            'name'      => 'required|string|max:255',
            'price'     => 'required|numeric',
            'image'     => 'required|image|max:10240', // 10MB
            'glb_model' => 'required|file|mimes:glb|max:102400'   // 100MB
        ]);

        // 2. IMAGE UPLOAD
        $imagePath = $request->file('image')->store('watches', 'public');

        // 3. GLB MODEL UPLOAD (Safe Rename)
        $glbFile = $request->file('glb_model');
        
        // Clean filename: "Apple Watch Ultra.glb" -> "apple_watch_ultra.glb"
        $cleanName = Str::slug(pathinfo($glbFile->getClientOriginalName(), PATHINFO_FILENAME));
        $fileName  = time() . '_' . $cleanName . '.glb';

        // Store file
        $glbPath = $glbFile->storeAs('watches', $fileName, 'public');

        // 4. SAVE TO DB
        Watch::create([
            'name'      => $request->name,
            'price'     => $request->price,
            'image'     => $imagePath,
            'glb_model' => $glbPath,
        ]);

        return redirect()->back()->with('success', 'Watch uploaded successfully!');
    }
}