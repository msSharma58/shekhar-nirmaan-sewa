<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable|boolean',
        ]);
        Testimonial::create([
            ...$request->only('name', 'location', 'message', 'rating'),
            'is_active' => $request->boolean('is_active'),
        ]);
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back()->with('success', 'Testimonial added!');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable|boolean',
        ]);
        $testimonial->update([
            ...$request->only('name', 'location', 'message', 'rating'),
            'is_active' => $request->boolean('is_active'),
        ]);
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back()->with('success', 'Testimonial updated!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back()->with('success', 'Testimonial deleted.');
    }

    public function toggle(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back();
    }
}
