<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact'); // your contact form blade
    }

   public function sendMessage(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
        'order_id' => 'nullable|string|max:100', // optional
    ]);

    // Case 1: Customer provides order_id => use that as the unique identifier
    // Case 2: No order_id => generate unique reference ID

    $uniqueReference = $request->order_id ?: 'TRMW-' . strtoupper(Str::random(6));

    // Send email with all details including uniqueReference
    Mail::to('ocmsoftware31@gmail.com')->send(new ContactMessageMail(
        $request->name,
        $request->email,
        $request->message,
        $uniqueReference
    ));

    return redirect()->back()->with('success', "Your message has been sent successfully! Your reference ID is {$uniqueReference}");
}
}
