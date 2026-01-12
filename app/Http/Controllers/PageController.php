<?php

namespace App\Http\Controllers;
use App\Models\Watch;

class PageController extends Controller
{
    public function home()
    {
        $watch = Watch::findOrFail(1);
        return view('home', compact('watch'));
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
