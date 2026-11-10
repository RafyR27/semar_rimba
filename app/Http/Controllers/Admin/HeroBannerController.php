<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroBannerRequest;
use App\Models\HeroBanner;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RuntimeException;

class HeroBannerController extends Controller
{
    /**
     * Display a listing of the hero banners.
     */
    public function index(): View
    {
        $banners = HeroBanner::query()
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.hero-banners.index', [
            'banners' => $banners,
        ]);
    }

    /**
     * Show the form for creating a new hero banner.
     */
    public function create(): View
    {
        return view('admin.hero-banners.create');
    }

    /**
     * Store a newly created hero banner in storage.
     */
    public function store(HeroBannerRequest $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validated();
        $file = $request->file('image');

        if (! $file) {
            return back()->withInput()->with('error', 'File gambar wajib diunggah.');
        }

        try {
            $upload = $cloudinary->upload($file, 'hero_banners');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        HeroBanner::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_url' => $upload['secure_url'],
            'image_public_id' => $upload['public_id'],
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'is_active' => (bool) $validated['is_active'],
            'order' => (int) $validated['order'],
        ]);

        return redirect()
            ->route('admin.hero-banners.index')
            ->with('status', 'Hero banner berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified hero banner.
     */
    public function edit(HeroBanner $heroBanner): View
    {
        return view('admin.hero-banners.edit', [
            'banner' => $heroBanner,
        ]);
    }

    /**
     * Update the specified hero banner in storage.
     */
    public function update(HeroBannerRequest $request, HeroBanner $heroBanner, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validated();

        $updateData = [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'is_active' => (bool) $validated['is_active'],
            'order' => (int) $validated['order'],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file) {
                try {
                    $upload = $cloudinary->upload($file, 'hero_banners');
                } catch (RuntimeException $e) {
                    return back()->withInput()->with('error', $e->getMessage());
                }

                // Delete previous image from Cloudinary safely
                $cloudinary->destroy($heroBanner->image_public_id);

                $updateData['image_url'] = $upload['secure_url'];
                $updateData['image_public_id'] = $upload['public_id'];
            }
        }

        $heroBanner->update($updateData);

        return redirect()
            ->route('admin.hero-banners.index')
            ->with('status', 'Hero banner berhasil diperbarui!');
    }

    /**
     * Remove the specified hero banner from storage.
     */
    public function destroy(HeroBanner $heroBanner, CloudinaryService $cloudinary): RedirectResponse
    {
        // Delete image asset from Cloudinary
        $cloudinary->destroy($heroBanner->image_public_id);

        // Delete database record
        $heroBanner->delete();

        return redirect()
            ->route('admin.hero-banners.index')
            ->with('status', 'Hero banner berhasil dihapus!');
    }

    /**
     * Toggle the active status of the specified hero banner.
     */
    public function toggleActive(HeroBanner $heroBanner): RedirectResponse
    {
        $heroBanner->update([
            'is_active' => ! $heroBanner->is_active,
        ]);

        $statusText = $heroBanner->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('status', "Hero banner berhasil {$statusText}!");
    }
}
