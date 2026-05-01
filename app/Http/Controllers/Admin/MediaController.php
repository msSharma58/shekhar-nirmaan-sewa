<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $media = \App\Models\Media::latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate(['files.*' => 'required|image|max:5120']);
        $rows = [];
        $now = now();

        foreach ($request->file('files') as $file) {
            $path = $file->store('media', 'public');
            $rows[] = [
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            \App\Models\Media::insert($rows);
        }

        return back()->with('success', count($request->file('files')) . ' file(s) uploaded!');
    }

    public function destroy(\App\Models\Media $media)
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return back()->with('success', 'File deleted.');
    }
}