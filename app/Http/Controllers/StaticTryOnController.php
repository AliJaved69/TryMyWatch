<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaticTryOnController extends Controller
{
    public function index()
    {
        $credits = Auth::check() ? Auth::user()->credits : session('guest_credits', 1);
        return view('static-try-on.index', compact('credits'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'wrist_image' => 'required|image|max:5120',
        ]);

        // Deduct credit
        if (Auth::check()) {
            $user = Auth::user();
            $user->credits -= 1;
            $user->save();
        } else {
            $guestCredits = session('guest_credits', 1);
            session(['guest_credits' => $guestCredits - 1]);
        }

        // Mock "Generation" - In a real app, this would call an AI API.
        // For this project, we'll return a selection of luxury watches.
        $watches = Product::limit(10)->get();
        
        // Simulating the uploaded image path for the gallery
        $path = $request->file('wrist_image')->store('temp_tryons', 'public');
        $wristImageUrl = Storage::url($path);

        return view('static-try-on.index', [
            'watches' => $watches,
            'wristImageUrl' => $wristImageUrl,
            'credits' => Auth::check() ? Auth::user()->credits : session('guest_credits', 0),
            'generated' => true
        ]);
    }
}
