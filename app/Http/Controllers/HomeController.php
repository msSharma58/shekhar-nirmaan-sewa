<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services     = Service::orderBy('sort_order')->get();
        $projects     = Project::orderByDesc('created_at')->get();
        $testimonials = Testimonial::where('is_active', true)->get();

        return view('home', compact('services', 'projects', 'testimonials'));
    }

    public function projectShow(Project $project)
    {
        $relatedProjects = Project::query()
            ->where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->latest()
            ->take(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
