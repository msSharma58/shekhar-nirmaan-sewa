<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'image_url_external' => 'nullable|url',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
                $data['image_url'] = $request->file('image')->store('projects', 'public');
        } elseif ($request->filled('image_url_external')) {
            $data['image_url'] = $request->image_url_external;
        }

        $data['is_featured'] = $request->boolean('is_featured');
        Project::create($data);

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
            'image_url_external' => 'nullable|url',
        ]);
        if ($request->hasFile('image')) {
            // Delete old file if stored locally
            if ($project->image_url && !str_starts_with($project->image_url, 'http')) {
                Storage::disk('public')->delete($project->image_url);
            }
            $data['image_url'] = $request->file('image')->store('projects', 'public');
        } elseif ($request->filled('image_url_external')) {
            $data['image_url'] = $request->image_url_external;
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        if ($project->image_url && !str_starts_with($project->image_url, 'http')) {
            Storage::disk('public')->delete($project->image_url);
        }
        $project->delete();
        return back()->with('success', 'Project deleted.');
    }

    public function toggle(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);
        return back();
    }
}
