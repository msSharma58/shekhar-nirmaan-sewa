<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class SettingsController extends Controller
{
    private function getSettings(): array
    {
        return \App\Models\Setting::pluck('value', 'key')->toArray();
    }

    public function index()
    {
        return view('admin.settings.index', ['settings' => $this->getSettings()]);
    }

    public function update(Request $request)
    {
        $fields = ['company_name','tagline','phone','email','address','instagram','facebook'];
        foreach ($fields as $key) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key, '')]);
        }
        return back()->with('success', 'Company info saved!');
    }

    public function updateHero(Request $request)
    {
        foreach (['hero_title','hero_highlight','hero_subtitle'] as $key) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key, '')]);
        }
        return back()->with('success', 'Hero section saved!');
    }

    public function updateStats(Request $request)
    {
        foreach (['stat_years','stat_projects','stat_clients','stat_workers'] as $key) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key, 0)]);
        }
        return back()->with('success', 'Stats saved!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $user = auth()->user();
        $user->name  = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return back()->with('success', 'Account updated!');
    }
}
