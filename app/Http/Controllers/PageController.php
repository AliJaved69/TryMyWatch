<?php

namespace App\Http\Controllers;
use App\Models\Watch;

class PageController extends Controller
{
    public function home()
    {
        $watch = Watch::find(3) ?? Watch::first();
        $products = \App\Models\Product::latest()->take(6)->get();
        return view('home', compact('watch', 'products'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
