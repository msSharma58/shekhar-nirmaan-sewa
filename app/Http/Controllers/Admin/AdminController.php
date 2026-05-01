<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalProjects'    => Project::count(),
            'totalServices'    => Service::count(),
            'totalTestimonials'=> Testimonial::where('is_active', true)->count(),
            'unreadMessages'   => Contact::where('is_read', false)->count(),
            'recentProjects'   => Project::latest()->take(5)->get(),
            'recentMessages'   => Contact::latest()->take(5)->get(),
            'monthlyStats'     => Contact::selectRaw('MONTHNAME(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
        ]);
    }

    public function login()  {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
     }

    public function loginPost(Request $request)
{
    // Validate input
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Attempt login
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->has('remember'))) {
        // Regenerate session (important for security)
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // Failed login
    return redirect()->back()
        ->withErrors(['email' => 'Invalid credentials'])
        ->withInput();
}
    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
