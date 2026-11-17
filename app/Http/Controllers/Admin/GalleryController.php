<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RuntimeException;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     */
    public function index(): View
    {
        $galleries = Gallery::query()
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.galleries.index', [
            'galleries' => $galleries,
        ]);
    }

    /**
     * Show the form for creating a new gallery item.
     */
    public function create(): View
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created gallery item in storage.
     */
    public function store(GalleryRequest $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validated();
        $file = $request->file('image');

        if (! $file) {
            return back()->withInput()->with('error', 'File gambar wajib diunggah.');
        }

        try {
            $upload = $cloudinary->upload($file, 'galleries');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        Gallery::create([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_url' => $upload['secure_url'],
            'image_public_id' => $upload['public_id'],
            'is_active' => (bool) $validated['is_active'],
            'order' => (int) $validated['order'],
        ]);

        return redirect()
            ->route('admin.galleries.index')
            ->with('status', 'Foto galeri berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(Gallery $gallery): View
    {
        return view('admin.galleries.edit', [
            'gallery' => $gallery,
        ]);
    }

    /**
     * Update the specified gallery item in storage.
     */
    public function update(GalleryRequest $request, Gallery $gallery, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validated();

        $updateData = [
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) $validated['is_active'],
            'order' => (int) $validated['order'],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file) {
                try {
                    $upload = $cloudinary->upload($file, 'galleries');
                } catch (RuntimeException $e) {
                    return back()->withInput()->with('error', $e->getMessage());
                }

                // Delete previous image from Cloudinary safely
                $cloudinary->destroy($gallery->image_public_id);

                $updateData['image_url'] = $upload['secure_url'];
                $updateData['image_public_id'] = $upload['public_id'];
            }
        }

        $gallery->update($updateData);

        return redirect()
            ->route('admin.galleries.index')
            ->with('status', 'Foto galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified gallery item from storage.
     */
    public function destroy(Gallery $gallery, CloudinaryService $cloudinary): RedirectResponse
    {
        // Delete image asset from Cloudinary
        $cloudinary->destroy($gallery->image_public_id);

        // Delete database record
        $gallery->delete();

        return redirect()
            ->route('admin.galleries.index')
            ->with('status', 'Foto galeri berhasil dihapus!');
    }

    /**
     * Toggle the active status of the specified gallery item.
     */
    public function toggleActive(Gallery $gallery): RedirectResponse
    {
        $gallery->update([
            'is_active' => ! $gallery->is_active,
        ]);

        $statusText = $gallery->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('status', "Foto galeri berhasil {$statusText}!");
    }
}
