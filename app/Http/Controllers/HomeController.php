<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Support\Collection;
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
                    ->get()
                    ->toArray(),
                'projects' => Project::query()
                    ->select(['id', 'title', 'category', 'location', 'image_url', 'created_at'])
                    ->orderByDesc('created_at')
                    ->get()
                    ->toArray(),
                'testimonials' => Testimonial::query()
                    ->select(['id', 'name', 'location', 'message', 'rating'])
                    ->where('is_active', true)
                    ->get()
                    ->toArray(),
            ];
        });
    
        // $services = $this->normalizeServices($payload['services'] ?? null);
        // if ($services->isEmpty()) {
        //     $services = Service::query()
        //         ->select(['id', 'title', 'description', 'icon', 'sort_order'])
        //         ->orderBy('sort_order')
        //         ->get()
        //         ->map(fn (Service $service) => (object) [
        //             'icon' => $service->icon,
        //             'title' => $service->title,
        //             'description' => $service->description,
        //         ]);
    
        //     Cache::forget('home.index.payload');
        // }
    
        // $projects = collect($payload['projects'] ?? [])
        //     ->filter(fn ($p) => $p instanceof \App\Models\Project)
        //     ->values();

        // $testimonials = collect($payload['testimonials'] ?? [])
        //     ->filter(fn ($t) => $t instanceof \App\Models\Testimonial)
        //     ->values();    
    
        return view('home', [
            'services'     => collect($payload['services'] ?? []),
            'projects'     => collect($payload['projects'] ?? []),
            'testimonials' => collect($payload['testimonials'] ?? []),
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

    private function normalizeServices(mixed $services): Collection
    {
        return collect($services)
            ->map(function ($service) {
                if ($service instanceof Service) {
                    return (object) [
                        'icon' => $service->icon,
                        'title' => $service->title,
                        'description' => $service->description,
                    ];
                }

                if (is_array($service) || is_object($service)) {
                    return (object) [
                        'icon' => data_get($service, 'icon'),
                        'title' => data_get($service, 'title'),
                        'description' => data_get($service, 'description'),
                    ];
                }

                return null;
            })
            ->filter(fn ($service) => filled($service?->title) || filled($service?->description) || filled($service?->icon))
            ->values();
    }
}
