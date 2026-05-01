<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class AdminContactController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', [
            'contacts' => Contact::latest()->paginate(20),
            'total'    => Contact::count(),
            'unread'   => Contact::where('is_read', false)->count(),
        ]);
    }

    public function markRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return back();
    }

    public function markAllRead()
    {
        Contact::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'All messages marked as read.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Message deleted.');
    }
}
