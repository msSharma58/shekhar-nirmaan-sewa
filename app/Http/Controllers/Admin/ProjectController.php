<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\OptimizeImageJob;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->when(request('category'), fn($q, $v) => $q->where('category', $v))
            ->when(request('status'),   fn($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create() { return view('admin.projects.create'); }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|in:residential,commercial,renovation,civil',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:completed,ongoing,planning',
            'is_featured' => 'nullable|boolean',
            'image'       => 'nullable|image|max:5120',
            'gallery_images'   => 'nullable|array',
            'gallery_images.*' => 'image|max:5120',
            'remove_gallery_images'   => 'nullable|array',
            'remove_gallery_images.*' => 'string',
            'image_url_external' => 'nullable|url',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('projects', 'public');
            OptimizeImageJob::dispatch('public', $data['image_url']);
        } elseif ($request->filled('image_url_external')) {
            $data['image_url'] = $request->image_url_external;
        }

        if ($request->hasFile('gallery_images')) {
            $data['gallery_images'] = collect($request->file('gallery_images'))
                ->map(fn($file) => $file->store('projects/gallery', 'public'))
                ->values()
                ->all();

            foreach ($data['gallery_images'] as $galleryImagePath) {
                OptimizeImageJob::dispatch('public', $galleryImagePath);
            }
        }

        $data['is_featured'] = $request->boolean('is_featured');
        Project::create($data);
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');

        return redirect()->route('admin.projects.index')->with('success', 'Project added successfully!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|in:residential,commercial,renovation,civil',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:completed,ongoing,planning',
            'is_featured' => 'nullable|boolean',
            'image'       => 'nullable|image|max:5120',
            'gallery_images'   => 'nullable|array',
            'gallery_images.*' => 'image|max:5120',
            'image_url_external' => 'nullable|url',
        ]);
        if ($request->hasFile('image')) {
            // Delete old file if stored locally
            if ($project->image_url && !str_starts_with($project->image_url, 'http')) {
                Storage::disk('public')->delete($project->image_url);
                Storage::disk('public')->delete($this->thumbnailPath($project->image_url));
            }
            $data['image_url'] = $request->file('image')->store('projects', 'public');
            OptimizeImageJob::dispatch('public', $data['image_url']);
        } elseif ($request->filled('image_url_external')) {
            $data['image_url'] = $request->image_url_external;
        }

        $existingGalleryImages = collect($project->gallery_images ?? []);
        $removeRequested = collect($request->input('remove_gallery_images', []));
        $imagesToRemove = $existingGalleryImages
            ->filter(fn($imagePath) => $removeRequested->contains($imagePath))
            ->values();

        if ($request->hasFile('gallery_images') || $imagesToRemove->isNotEmpty()) {
            foreach ($imagesToRemove as $imageToRemove) {
                if (!str_starts_with($imageToRemove, 'http')) {
                    Storage::disk('public')->delete($imageToRemove);
                    Storage::disk('public')->delete($this->thumbnailPath($imageToRemove));
                }
            }

            $remainingGalleryImages = $existingGalleryImages
                ->reject(fn($imagePath) => $imagesToRemove->contains($imagePath))
                ->values();

            if ($request->hasFile('gallery_images')) {
                $newGalleryImages = collect($request->file('gallery_images'))
                    ->map(fn($file) => $file->store('projects/gallery', 'public'))
                    ->values();

                foreach ($newGalleryImages as $newGalleryImagePath) {
                    OptimizeImageJob::dispatch('public', $newGalleryImagePath);
                }

                $remainingGalleryImages = $remainingGalleryImages->concat($newGalleryImages)->values();
            }

            $data['gallery_images'] = $remainingGalleryImages->all();
        }

        $data['is_featured'] = $request->boolean('is_featured');

        $project->update($data);
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');

        return redirect()->route('admin.projects.index')->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        if ($project->image_url && !str_starts_with($project->image_url, 'http')) {
            Storage::disk('public')->delete($project->image_url);
            Storage::disk('public')->delete($this->thumbnailPath($project->image_url));
        }
        foreach (($project->gallery_images ?? []) as $galleryImage) {
            if (!str_starts_with($galleryImage, 'http')) {
                Storage::disk('public')->delete($galleryImage);
                Storage::disk('public')->delete($this->thumbnailPath($galleryImage));
            }
        }
        $project->delete();
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back()->with('success', 'Project deleted.');
    }

    public function toggle(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);
        Cache::forget('home.index.payload');
        Cache::forget('admin.dashboard.stats');
        return back();
    }

    private function thumbnailPath(string $path): string
    {
        $dirname = pathinfo($path, PATHINFO_DIRNAME);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $dirPrefix = $dirname === '.' ? '' : ($dirname . '/');

        return $dirPrefix . $filename . '_thumb.webp';
    }
}
