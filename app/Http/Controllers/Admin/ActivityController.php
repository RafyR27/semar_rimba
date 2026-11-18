<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class ActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     */
    public function index(): View
    {
        $activities = Activity::query()
            ->ordered()
            ->paginate(15);

        return view('admin.activities.index', [
            'activities' => $activities,
        ]);
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create(): View
    {
        return view('admin.activities.create');
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(ActivityRequest $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validated();
        $file = $request->file('image');

        if (! $file) {
            return back()->withInput()->with('error', 'File gambar wajib diunggah.');
        }

        try {
            $upload = $cloudinary->upload($file, 'activities');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        Activity::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(5)),
            'category' => $validated['category'],
            'location' => $validated['location'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'description' => $validated['description'],
            'image_url' => $upload['secure_url'],
            'image_public_id' => $upload['public_id'],
            'is_active' => (bool) $validated['is_active'],
            'order' => (int) $validated['order'],
        ]);

        return redirect()
            ->route('admin.activities.index')
            ->with('status', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity): View
    {
        return view('admin.activities.edit', [
            'activity' => $activity,
        ]);
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(ActivityRequest $request, Activity $activity, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validated();

        $updateData = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'location' => $validated['location'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'description' => $validated['description'],
            'is_active' => (bool) $validated['is_active'],
            'order' => (int) $validated['order'],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file) {
                try {
                    $upload = $cloudinary->upload($file, 'activities');
                } catch (RuntimeException $e) {
                    return back()->withInput()->with('error', $e->getMessage());
                }

                // Delete previous image from Cloudinary safely
                $cloudinary->destroy($activity->image_public_id);

                $updateData['image_url'] = $upload['secure_url'];
                $updateData['image_public_id'] = $upload['public_id'];
            }
        }

        $activity->update($updateData);

        return redirect()
            ->route('admin.activities.index')
            ->with('status', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(Activity $activity, CloudinaryService $cloudinary): RedirectResponse
    {
        // Delete image asset from Cloudinary
        $cloudinary->destroy($activity->image_public_id);

        // Delete database record
        $activity->delete();

        return redirect()
            ->route('admin.activities.index')
            ->with('status', 'Kegiatan berhasil dihapus!');
    }

    /**
     * Toggle the active/publish status of the specified activity.
     */
    public function toggleActive(Activity $activity): RedirectResponse
    {
        $activity->update([
            'is_active' => ! $activity->is_active,
        ]);

        $statusText = $activity->is_active ? 'dipublikasikan' : 'disembunyikan (draft)';

        return back()->with('status', "Kegiatan berhasil {$statusText}!");
    }
}
