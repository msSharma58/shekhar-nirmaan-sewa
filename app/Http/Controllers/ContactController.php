<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'service' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'service' => $request->service,
            'message' => $request->message,
        ]);

        return redirect()->route('home', '#contact')
            ->with('success', '✓ Thank you, ' . $request->name . '! We will contact you shortly.');
    }
}
