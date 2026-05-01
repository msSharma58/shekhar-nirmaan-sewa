<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);
        Service::create($request->only('title', 'description', 'icon', 'sort_order'));
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back()->with('success', 'Service added!');
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);
        $service->update($request->only('title', 'description', 'icon', 'sort_order'));
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back()->with('success', 'Service updated!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back()->with('success', 'Service deleted.');
    }
}