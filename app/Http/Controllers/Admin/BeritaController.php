<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\Berita;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class BeritaController extends Controller
{
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
     * Display a listing of the news entries.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = Berita::query();

        if ($user?->role === 'penulis') {
            $query->where('user_id', $user->id);
        } elseif ($this->isReviewer($user)) {
            $query->whereIn('status', ['review', 'published', 'archived']);
        }

        $beritas = $query
            ->when($search !== '', function (Builder $query) use ($search): void {
                $pattern = '%'.mb_strtolower($search).'%';
                $query->whereRaw('LOWER(judul) LIKE ?', [$pattern]);
            })
            ->when(
                in_array($status, ['draft', 'review', 'published', 'archived'], true),
                fn (Builder $query) => $query->where('status', $status)
            )
            ->latestPublished()
            ->paginate(10)
            ->withQueryString();

        return view('admin.beritas.index', [
            'beritas' => $beritas,
            'search' => $search,
            'status' => $status,
            'routePrefix' => $this->routePrefix($user),
        ]);
    }

    /**
     * Show the form for creating a new news entry.
     */
    public function create(Request $request): View
    {
        if ($this->isReviewer($request->user())) {
            abort(403);
        }

        return view('admin.beritas.create', [
            'routePrefix' => $this->routePrefix($request->user()),
        ]);
    }

    /**
     * Store a newly created news entry in storage.
     */
    public function store(BeritaRequest $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $user = $request->user();

        if ($this->isReviewer($user)) {
            abort(403);
        }

        $validated = $request->validated();
        $file = $request->file('thumbnail');

        if (! $file) {
            return back()->withInput()->with('error', 'File gambar berita wajib diunggah.');
        }

        try {
            $upload = $cloudinary->upload($file, 'beritas');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        try {
            DB::transaction(function () use ($user, $validated, $upload): void {
                Berita::create([
                    'user_id' => $user?->id,
                    'judul' => $validated['judul'],
                    'slug' => $this->uniqueSlug($validated['slug'] ?? $validated['judul']),
                    'konten' => $validated['konten'],
                    'thumbnail_url' => $upload['secure_url'],
                    'thumbnail_public_id' => $upload['public_id'],
                    'tanggal_terbit' => $validated['tanggal_terbit'] ?? now()->toDateString(),
                    'status' => $validated['status'],
                    'is_published' => $validated['status'] === 'published',
                ]);
            });
        } catch (Throwable $e) {
            // No row exists, so the freshly uploaded asset must not survive.
            $this->discardUploadedAsset($cloudinary, $upload['public_id'], 'store');

            Log::error('Gagal menyimpan berita setelah thumbnail diunggah ke Cloudinary', [
                'public_id' => $upload['public_id'],
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Berita gagal disimpan. Gambar yang terlanjur diunggah sudah dibatalkan, silakan coba lagi.');
        }

        return redirect()
            ->route($this->routePrefix($user).'.beritas.index')
            ->with('status', 'Berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified news entry.
     */
    public function edit(Request $request, Berita $berita): View
    {
        $user = $request->user();

        if ($user?->role === 'penulis' && $berita->user_id !== $user->id) {
            abort(403);
        }

        return view('admin.beritas.edit', [
            'berita' => $berita,
            'routePrefix' => $this->routePrefix($user),
        ]);
    }

    /**
     * Update the specified news entry in storage.
     */
    public function update(BeritaRequest $request, Berita $berita, CloudinaryService $cloudinary): RedirectResponse
    {
        $user = $request->user();

        if ($user?->role === 'penulis' && $berita->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validated();
        $previousPublicId = $berita->thumbnail_public_id;

        $updateData = [
            'judul' => $validated['judul'],
            'slug' => $this->uniqueSlug($validated['slug'] ?? $validated['judul'], $berita),
            'konten' => $validated['konten'],
            'tanggal_terbit' => $validated['tanggal_terbit'] ?? null,
            'status' => $validated['status'],
            'is_published' => $validated['status'] === 'published',
        ];

        $newUpload = null;
        $file = $request->file('thumbnail');

        if ($file) {
            try {
                $newUpload = $cloudinary->upload($file, 'beritas');
            } catch (RuntimeException $e) {
                return back()->withInput()->with('error', $e->getMessage());
            }

            $updateData['thumbnail_url'] = $newUpload['secure_url'];
            $updateData['thumbnail_public_id'] = $newUpload['public_id'];
        }

        try {
            DB::transaction(fn () => $berita->update($updateData));
        } catch (Throwable $e) {
            // The row still references the previous thumbnail, so drop only the new asset.
            if ($newUpload !== null) {
                $this->discardUploadedAsset($cloudinary, $newUpload['public_id'], 'update');
            }

            Log::error('Gagal memperbarui berita', [
                'berita_id' => $berita->getKey(),
                'public_id' => $newUpload['public_id'] ?? null,
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Berita gagal diperbarui. Perubahan database dibatalkan dan thumbnail lama tetap digunakan.');
        }

        // Only after the row is committed does the previous asset become unreferenced.
        if ($newUpload !== null) {
            $this->destroyPreviousAsset($cloudinary, $previousPublicId, $berita->getKey());
        }

        return redirect()
            ->route($this->routePrefix($user).'.beritas.index')
            ->with('status', 'Berita berhasil diperbarui!');
    }

    /**
     * Update the workflow status of the specified news entry based on user role.
     */
    public function updateStatus(Request $request, Berita $berita): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:draft,review,published,archived'],
        ]);

        $targetStatus = $validated['status'];
        $currentStatus = $berita->status ?? ($berita->is_published ? 'published' : 'draft');

        if ($this->isReviewer($user)) {
            $allowed = ($currentStatus === 'review' && $targetStatus === 'published')
                || ($currentStatus === 'published' && $targetStatus === 'archived');

            if (! $allowed) {
                return back()->with('error', 'Perubahan status tidak diizinkan untuk status berita saat ini.');
            }
        } elseif ($user?->role === 'penulis') {
            if ($berita->user_id !== $user->id) {
                abort(403);
            }

            if (! in_array($currentStatus, ['draft', 'review'], true) || ! in_array($targetStatus, ['draft', 'review'], true)) {
                return back()->with('error', 'Penulis hanya dapat mengubah status antara Draft dan Review.');
            }
        } else {
            abort(403);
        }

        $berita->update([
            'status' => $targetStatus,
            'is_published' => $targetStatus === 'published',
        ]);

        $statusLabel = match ($targetStatus) {
            'published' => 'diterbitkan (Published)',
            'archived' => 'diarsipkan (Archived)',
            'review' => 'diajukan untuk Review',
            default => 'dikembalikan ke Draft',
        };

        return back()->with('status', "Status berita berhasil {$statusLabel}!");
    }

    /**
     * Remove the specified news entry from storage.
     */
    public function destroy(Request $request, Berita $berita, CloudinaryService $cloudinary): RedirectResponse
    {
        $user = $request->user();
        $currentStatus = $berita->status ?? ($berita->is_published ? 'published' : 'draft');

        if ($this->isReviewer($user)) {
            if (! in_array($currentStatus, ['review', 'archived'], true)) {
                return back()->with('error', 'Admin dan Staff hanya dapat menghapus berita berstatus Review atau Archived.');
            }
        } elseif ($user?->role === 'penulis') {
            if ($berita->user_id !== $user->id) {
                abort(403);
            }

            if ($currentStatus !== 'draft') {
                return back()->with('error', 'Penulis hanya dapat menghapus berita yang berstatus Draft.');
            }
        } else {
            abort(403);
        }

        $beritaId = $berita->getKey();
        $publicId = $berita->thumbnail_public_id;

        try {
            DB::transaction(fn () => $berita->delete());
        } catch (Throwable $e) {
            // Keep the record and its thumbnail intact when the deletion does not go through.
            Log::error('Gagal menghapus berita dari database', [
                'berita_id' => $beritaId,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Berita gagal dihapus. Tidak ada perubahan yang disimpan, silakan coba lagi.');
        }

        if (! empty($publicId) && ! $cloudinary->destroy($publicId)) {
            Log::warning('Asset Cloudinary gagal dihapus setelah berita dihapus dari database', [
                'berita_id' => $beritaId,
                'public_id' => $publicId,
            ]);
        }

        return redirect()
            ->route($this->routePrefix($user).'.beritas.index')
            ->with('status', 'Berita berhasil dihapus!');
    }

    /**
     * Toggle the publication status of the specified news entry.
     */
    public function togglePublish(Berita $berita): RedirectResponse
    {
        $nextPublished = ! $berita->is_published;

        $berita->update([
            'status' => $nextPublished ? 'published' : 'draft',
            'is_published' => $nextPublished,
        ]);

        $statusText = $berita->is_published ? 'diterbitkan' : 'disimpan sebagai draft';

        return back()->with('status', "Berita berhasil {$statusText}!");
    }

    /**
     * Build a unique slug, appending a counter when the base slug is taken.
     */
    protected function uniqueSlug(string $value, ?Berita $ignore = null): string
    {
        $base = Str::slug($value);

        if ($base === '') {
            $base = Str::random(8);
        }

        $slug = $base;
        $counter = 1;

        while (Berita::query()
            ->where('slug', $slug)
            ->when($ignore, fn (Builder $query) => $query->whereKeyNot($ignore->getKey()))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Remove an asset that was uploaded for a write operation that did not commit.
     */
    protected function discardUploadedAsset(CloudinaryService $cloudinary, ?string $publicId, string $context): void
    {
        if (empty($publicId)) {
            return;
        }

        if (! $cloudinary->destroy($publicId)) {
            Log::error('Kompensasi gagal: asset Cloudinary sisa operasi yang dibatalkan tidak dapat dihapus', [
                'context' => $context,
                'public_id' => $publicId,
            ]);
        }
    }

    /**
     * Remove the asset that was replaced by a committed update.
     */
    protected function destroyPreviousAsset(CloudinaryService $cloudinary, ?string $publicId, int|string $beritaId): void
    {
        if (empty($publicId)) {
            return;
        }

        if (! $cloudinary->destroy($publicId)) {
            Log::warning('Asset Cloudinary lama gagal dihapus setelah berita diperbarui', [
                'berita_id' => $beritaId,
                'public_id' => $publicId,
            ]);
        }
    }
}
