<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContactEntry;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'subject' => 'nullable|string|max:255',
        ]);

        // Save to Database
        ContactEntry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'subject' => $validated['subject'] ?? null,
        ]);

        // Optional: Send Email (commented out if not configured, or kept if working)
        // Mail::to('ocmsoftware31@gmail.com')->send(new ContactMessageMail(...));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
