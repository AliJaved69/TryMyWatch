<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEntry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $entries = ContactEntry::latest()->paginate(15);
        return view('admin.contact.index', compact('entries'));
    }

    public function show(ContactEntry $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        return view('admin.contact.show', ['entry' => $contact]);
    }

    public function destroy(ContactEntry $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contact.index')->with('success', 'Message deleted successfully.');
    }
}
