<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminMediaController extends Controller
{
    public function index(Request $request): View
    {
        $query = \App\Models\Media::query()->with('uploader');

        if ($request->filled('q')) {
            $term = $request->string('q')->toString();
            $query->where(function ($inner) use ($term) {
                $inner->where('name', 'like', "%{$term}%")
                    ->orWhere('file_name', 'like', "%{$term}%")
                    ->orWhere('alt_text', 'like', "%{$term}%");
            });
        }

        if ($request->filled('folder')) {
            $query->where('folder', $request->string('folder')->toString());
        }

        if ($request->input('type') === 'image') {
            $query->where('mime_type', 'like', 'image/%');
        }

        return view('admin.media.index', [
            'items' => $query->latest()->paginate(24)->withQueryString(),
            'folders' => \App\Models\Media::query()->distinct()->orderBy('folder')->pluck('folder'),
        ]);
    }

    public function picker(Request $request): View
    {
        return view('admin.media.picker', [
            'items' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->latest()
                ->limit(48)
                ->get(),
        ]);
    }

    public function upload(Request $request, MediaUploader $uploader): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:8192'],
            'folder' => ['nullable', 'string', 'max:60'],
        ]);

        try {
            $stored = $uploader->store($request->file('file'), $request->input('folder', 'uploads'));
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $media = \App\Models\Media::query()->create([
            'name' => pathinfo($stored['file_name'], PATHINFO_FILENAME),
            'file_name' => $stored['file_name'],
            'path' => $stored['path'],
            'disk' => 'public',
            'mime_type' => $stored['mime_type'],
            'size' => $stored['size'],
            'width' => $stored['width'],
            'height' => $stored['height'],
            'folder' => $request->input('folder', 'uploads'),
            'user_id' => $request->user()?->id,
        ]);

        return response()->json([
            'id' => $media->id,
            'url' => $media->url(),
            'path' => $media->path,
        ]);
    }

    public function update(Request $request, \App\Models\Media $medium): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'alt_text' => ['nullable', 'string', 'max:200'],
        ]);

        $medium->update($validated);

        return back()->with('status', 'Media updated.');
    }

    public function destroy(\App\Models\Media $medium): \Illuminate\Http\RedirectResponse
    {
        Storage::disk($medium->disk ?: 'public')->delete($medium->path);
        $medium->delete();

        return back()->with('status', 'Media deleted.');
    }
}
