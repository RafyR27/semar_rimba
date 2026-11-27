<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ActivityController extends Controller
{
    /**
     * Private Laravel storage disk used for activity supporting documents.
     */
    private const DOCUMENT_DISK = 'local';

    /**
     * Directory within the private disk where activity documents are stored.
     */
    private const DOCUMENT_DIRECTORY = 'activity-documents';

    /**
     * Resolve the route prefix based on the authenticated user's role.
     */
    protected function routePrefix(?User $user): string
    {
        return match ($user?->role) {
            'admin' => 'admin',
            'penulis' => 'penulis',
            default => 'staff',
        };
    }

    /**
     * Determine whether the user is an admin or staff reviewer.
     */
    protected function isReviewer(?User $user): bool
    {
        return in_array($user?->role, ['admin', 'staff'], true);
    }

    /**
     * Display a listing of the activities.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $search = trim((string) $request->query('search', ''));
        $category = trim((string) $request->query('category', ''));
        $status = trim((string) $request->query('status', ''));

        $query = Activity::query()->ordered();

        if ($user?->role === 'penulis') {
            $query->where('user_id', $user->id);
        } elseif ($this->isReviewer($user)) {
            $query->whereIn('status', ['review', 'published', 'archived']);
        }

        $activities = $query
            ->when($search !== '', function (Builder $query) use ($search): void {
                $pattern = '%'.mb_strtolower($search).'%';
                $query->where(function (Builder $query) use ($pattern): void {
                    $query->whereRaw('LOWER(title) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(location) LIKE ?', [$pattern]);
                });
            })
            ->when(
                in_array($category, ['Ekspedisi', 'Diklat', 'SAR & Kemanusiaan', 'Konservasi', 'Umum'], true),
                fn (Builder $query) => $query->where('category', $category)
            )
            ->when(
                in_array($status, ['draft', 'review', 'published', 'archived'], true),
                fn (Builder $query) => $query->where('status', $status)
            )
            ->paginate(15)
            ->withQueryString();

        return view('admin.activities.index', [
            'activities' => $activities,
            'search' => $search,
            'category' => $category,
            'status' => $status,
            'routePrefix' => $this->routePrefix($user),
        ]);
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create(Request $request): View
    {
        if ($this->isReviewer($request->user())) {
            abort(403);
        }

        return view('admin.activities.create', [
            'routePrefix' => $this->routePrefix($request->user()),
        ]);
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(ActivityRequest $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $user = $request->user();

        if ($this->isReviewer($user)) {
            abort(403);
        }

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

        $documentAttributes = [
            'document_path' => null,
            'document_original_name' => null,
            'document_mime_type' => null,
            'document_size' => null,
        ];

        $documentFile = $request->file('document');
        if ($documentFile instanceof UploadedFile) {
            $documentAttributes = $this->storePrivateDocument($documentFile);
        }

        try {
            Activity::create([
                'user_id' => $user?->id,
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(5)),
                'category' => $validated['category'],
                'location' => $validated['location'] ?? null,
                'event_date' => $validated['event_date'] ?? null,
                'description' => $validated['description'],
                'image_url' => $upload['secure_url'],
                'image_public_id' => $upload['public_id'],
                ...$documentAttributes,
                'status' => $validated['status'],
                'is_active' => $validated['status'] === 'published',
                'order' => (int) $validated['order'],
            ]);
        } catch (Throwable $e) {
            $this->deletePrivateDocument($documentAttributes['document_path']);
            $cloudinary->destroy($upload['public_id']);

            return back()->withInput()->with('error', 'Kegiatan gagal disimpan. Silakan coba lagi.');
        }

        return redirect()
            ->route($this->routePrefix($user).'.activities.index')
            ->with('status', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Request $request, Activity $activity): View
    {
        $user = $request->user();

        if ($user?->role === 'penulis' && $activity->user_id !== $user->id) {
            abort(403);
        }

        return view('admin.activities.edit', [
            'activity' => $activity,
            'routePrefix' => $this->routePrefix($user),
        ]);
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(ActivityRequest $request, Activity $activity, CloudinaryService $cloudinary): RedirectResponse
    {
        $user = $request->user();

        if ($user?->role === 'penulis' && $activity->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validated();

        $updateData = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'location' => $validated['location'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'description' => $validated['description'],
            'status' => $validated['status'],
            'is_active' => $validated['status'] === 'published',
            'order' => (int) $validated['order'],
        ];

        $previousImagePublicId = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file) {
                try {
                    $upload = $cloudinary->upload($file, 'activities');
                } catch (RuntimeException $e) {
                    return back()->withInput()->with('error', $e->getMessage());
                }

                $previousImagePublicId = $activity->image_public_id;
                $updateData['image_url'] = $upload['secure_url'];
                $updateData['image_public_id'] = $upload['public_id'];
            }
        }

        $previousDocumentPath = $activity->document_path;
        $newDocumentPath = null;
        $shouldRemoveOldDocument = false;

        $documentFile = $request->file('document');
        if ($documentFile instanceof UploadedFile) {
            $storedDocument = $this->storePrivateDocument($documentFile);
            $newDocumentPath = $storedDocument['document_path'];
            $updateData = array_merge($updateData, $storedDocument);
            $shouldRemoveOldDocument = ! empty($previousDocumentPath);
        } elseif ($request->boolean('remove_document') && ! empty($previousDocumentPath)) {
            $updateData['document_path'] = null;
            $updateData['document_original_name'] = null;
            $updateData['document_mime_type'] = null;
            $updateData['document_size'] = null;
            $shouldRemoveOldDocument = true;
        }

        try {
            $activity->update($updateData);
        } catch (Throwable $e) {
            $this->deletePrivateDocument($newDocumentPath);

            return back()->withInput()->with('error', 'Kegiatan gagal diperbarui. Silakan coba lagi.');
        }

        if ($previousImagePublicId !== null) {
            $cloudinary->destroy($previousImagePublicId);
        }

        if ($shouldRemoveOldDocument) {
            $this->deletePrivateDocument($previousDocumentPath);
        }

        return redirect()
            ->route($this->routePrefix($user).'.activities.index')
            ->with('status', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Download the private supporting document attached to an activity if authorized.
     */
    public function downloadDocument(Request $request, Activity $activity): StreamedResponse
    {
        $user = $request->user();
        $currentStatus = $activity->status ?? ($activity->is_active ? 'published' : 'draft');

        if ($this->isReviewer($user)) {
            if (! in_array($currentStatus, ['review', 'published', 'archived'], true)) {
                abort(403);
            }
        } elseif ($user?->role === 'penulis') {
            if ($activity->user_id !== $user->id) {
                abort(403);
            }
        } else {
            abort(403);
        }

        if (empty($activity->document_path) || ! Storage::disk(self::DOCUMENT_DISK)->exists($activity->document_path)) {
            abort(404, 'Dokumen pendukung tidak ditemukan.');
        }

        $downloadName = $activity->document_original_name ?: basename($activity->document_path);

        return Storage::disk(self::DOCUMENT_DISK)->download($activity->document_path, $downloadName);
    }

    /**
     * Update the workflow status of the specified activity based on user role.
     */
    public function updateStatus(Request $request, Activity $activity): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:draft,review,published,archived'],
        ]);

        $targetStatus = $validated['status'];
        $currentStatus = $activity->status ?? ($activity->is_active ? 'published' : 'draft');

        if ($this->isReviewer($user)) {
            $allowed = ($currentStatus === 'review' && $targetStatus === 'published')
                || ($currentStatus === 'published' && $targetStatus === 'archived');

            if (! $allowed) {
                return back()->with('error', 'Perubahan status tidak diizinkan untuk status kegiatan saat ini.');
            }
        } elseif ($user?->role === 'penulis') {
            if ($activity->user_id !== $user->id) {
                abort(403);
            }

            if (! in_array($currentStatus, ['draft', 'review'], true) || ! in_array($targetStatus, ['draft', 'review'], true)) {
                return back()->with('error', 'Penulis hanya dapat mengubah status antara Draft dan Review.');
            }
        } else {
            abort(403);
        }

        $activity->update([
            'status' => $targetStatus,
            'is_active' => $targetStatus === 'published',
        ]);

        $statusLabel = match ($targetStatus) {
            'published' => 'dipublikasikan (Published)',
            'archived' => 'diarsipkan (Archived)',
            'review' => 'diajukan untuk Review',
            default => 'dikembalikan ke Draft',
        };

        return back()->with('status', "Status kegiatan berhasil {$statusLabel}!");
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(Request $request, Activity $activity, CloudinaryService $cloudinary): RedirectResponse
    {
        $user = $request->user();
        $currentStatus = $activity->status ?? ($activity->is_active ? 'published' : 'draft');

        if ($this->isReviewer($user)) {
            if (! in_array($currentStatus, ['review', 'archived'], true)) {
                return back()->with('error', 'Admin dan Staff hanya dapat menghapus kegiatan berstatus Review atau Archived.');
            }
        } elseif ($user?->role === 'penulis') {
            if ($activity->user_id !== $user->id) {
                abort(403);
            }

            if ($currentStatus !== 'draft') {
                return back()->with('error', 'Penulis hanya dapat menghapus kegiatan yang berstatus Draft.');
            }
        } else {
            abort(403);
        }

        $documentPath = $activity->document_path;

        // Delete image asset from Cloudinary
        $cloudinary->destroy($activity->image_public_id);

        // Delete database record
        $activity->delete();

        // Delete attached private document after DB record is removed
        $this->deletePrivateDocument($documentPath);

        return redirect()
            ->route($this->routePrefix($user).'.activities.index')
            ->with('status', 'Kegiatan berhasil dihapus!');
    }

    /**
     * Toggle the active/publish status of the specified activity.
     */
    public function toggleActive(Activity $activity): RedirectResponse
    {
        $nextActive = ! $activity->is_active;

        $activity->update([
            'status' => $nextActive ? 'published' : 'draft',
            'is_active' => $nextActive,
        ]);

        $statusText = $activity->is_active ? 'dipublikasikan' : 'disembunyikan (draft)';

        return back()->with('status', "Kegiatan berhasil {$statusText}!");
    }

    /**
     * Store a validated supporting document in the private Laravel disk.
     *
     * @return array{
     *     document_path: string,
     *     document_original_name: string,
     *     document_mime_type: string|null,
     *     document_size: int|null
     * }
     */
    protected function storePrivateDocument(UploadedFile $file): array
    {
        $storedPath = $file->store(self::DOCUMENT_DIRECTORY, self::DOCUMENT_DISK);

        if ($storedPath === false) {
            throw new RuntimeException('Gagal menyimpan dokumen pendukung ke penyimpanan.');
        }

        $originalName = basename($file->getClientOriginalName());
        $size = $file->getSize();

        return [
            'document_path' => $storedPath,
            'document_original_name' => $originalName !== '' ? $originalName : basename($storedPath),
            'document_mime_type' => $file->getClientMimeType(),
            'document_size' => is_int($size) ? $size : null,
        ];
    }

    /**
     * Safely delete an existing private document from storage if it exists.
     */
    protected function deletePrivateDocument(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        if (Storage::disk(self::DOCUMENT_DISK)->exists($path)) {
            Storage::disk(self::DOCUMENT_DISK)->delete($path);
        }
    }
}
