<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\OptimizeImageJob;
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
        $paths = [];
        $now = now();

        foreach ($request->file('files') as $file) {
            $path = $file->store('media', 'public');
            $paths[] = $path;
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
        foreach ($paths as $path) {
            OptimizeImageJob::dispatch('public', $path);
        }

        return back()->with('success', count($request->file('files')) . ' file(s) uploaded!');
    }

    public function destroy(\App\Models\Media $media)
    {
        Storage::disk('public')->delete($media->file_path);
        Storage::disk('public')->delete($this->thumbnailPath($media->file_path));
        $media->delete();
        return back()->with('success', 'File deleted.');
    }

    private function thumbnailPath(string $path): string
    {
        $dirname = pathinfo($path, PATHINFO_DIRNAME);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $dirPrefix = $dirname === '.' ? '' : ($dirname . '/');

        return $dirPrefix . $filename . '_thumb.webp';
    }
}