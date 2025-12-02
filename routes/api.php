<?php
use Illuminate\Http\Request;

Route::middleware('api')->get('/check-auth', function (Request $request) {
    return response()->json([
        'authenticated' => auth()->check(),
    ]);
});
