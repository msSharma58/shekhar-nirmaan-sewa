<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $payload = Cache::remember('home.index.payload', now()->addMinutes(5), function () {
            return [
                'services' => Service::query()
                    ->select(['id', 'title', 'description', 'icon', 'sort_order'])
                    ->orderBy('sort_order')
                    ->get(),
                'projects' => Project::query()
                    ->select(['id', 'title', 'category', 'location', 'image_url', 'created_at'])
                    ->orderByDesc('created_at')
                    ->get(),
                'testimonials' => Testimonial::query()
                    ->select(['id', 'name', 'location', 'message', 'rating', 'is_active', 'created_at'])
                    ->where('is_active', true)
                    ->get(),
            ];
        });

        return view('home', [
            'services' => $payload['services'],
            'projects' => $payload['projects'],
            'testimonials' => $payload['testimonials'],
        ]);
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
