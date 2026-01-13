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

    public function try($id)
    {
        $watch = Watch::findOrFail($id);
        return view('watch.try', compact('watch'));
    }

    public function store(Request $request)
    {
        // 1. VALIDATION
        // We removed 'mimes:glb' because it often fails on Windows. 
        // We rely on 'file' and extension checking instead.
        $request->validate([
            'name'      => 'required|string|max:255',
            'price'     => 'required|numeric',
            'image'     => 'required|image|max:10240', // 10MB
            'glb_model' => 'required|file|max:102400'   // 100MB
        ]);

        // 2. IMAGE UPLOAD
        $imagePath = $request->file('image')->store('watches', 'public');

        // 3. GLB MODEL UPLOAD (Safe Rename)
        $glbFile = $request->file('glb_model');
        
        // Clean filename: "Apple Watch Ultra.glb" -> "apple_watch_ultra.glb"
        $cleanName = Str::slug(pathinfo($glbFile->getClientOriginalName(), PATHINFO_FILENAME));
        $fileName  = time() . '_' . $cleanName . '.glb';

        // Check Extension Manually
        if (strtolower($glbFile->getClientOriginalExtension()) !== 'glb') {
            return back()->withErrors(['glb_model' => 'The file must be a .glb file.']);
        }

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