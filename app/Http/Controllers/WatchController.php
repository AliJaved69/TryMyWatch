<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watch;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png',
            'glb_model' => 'required|file|max:51200'
        ]);

        // Store files
        $imagePath = $request->file('image')->store('watches', 'public');
        $glbPath   = $request->file('glb_model')->store('watches', 'public');

        Watch::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'glb_model' => $glbPath,
        ]);

        return redirect()->back()->with('success', 'Watch added successfully!');
    }
}
