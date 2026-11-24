<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationProfileRequest;
use App\Models\OrganizationProfile;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class OrganizationProfileController extends Controller
{
    /**
     * Show the organization profile and contact settings page.
     */
    public function edit(): View
    {
        return view('admin.organization-profile.edit', [
            'profile' => OrganizationProfile::current(),
        ]);
    }

    /**
     * Update the organization profile and contact information.
     */
    public function update(OrganizationProfileRequest $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['logo']);

        $previousPublicId = null;
        $upload = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            if ($file !== null) {
                try {
                    $upload = $cloudinary->upload($file, 'organization');
                } catch (RuntimeException $e) {
                    return back()->withInput()->with('error', $e->getMessage());
                }

                $validated['logo_url'] = $upload['secure_url'];
                $validated['logo_public_id'] = $upload['public_id'];
            }
        }

        try {
            DB::transaction(function () use ($validated, &$previousPublicId): void {
                $profile = OrganizationProfile::query()->orderBy('id')->lockForUpdate()->first();
                $previousPublicId = $profile?->logo_public_id;

                if ($profile === null) {
                    try {
                        OrganizationProfile::create($validated);
                    } catch (QueryException $e) {
                        // Bukan konflik singleton -> jangan tangani sebagai duplikasi,
                        // biarkan transaksi rollback dan penanganan error di luar menangani.
                        if (! $this->isSingletonConflict($e)) {
                            throw $e;
                        }

                        // Request lain telah menang insert; baca ulis baris yang sudah ada.
                        $profile = OrganizationProfile::query()->orderBy('id')->lockForUpdate()->first();
                        $previousPublicId = $profile?->logo_public_id;

                        if ($profile === null) {
                            // Tidak ditemukan padahal constraint melanggar -> re-throw.
                            throw $e;
                        }

                        $profile->update($validated);
                    }

                    return;
                }

                $profile->update($validated);
            });
        } catch (Throwable $e) {
            if ($upload !== null) {
                $this->discardUploadedAsset($cloudinary, $upload['public_id']);
            }

            Log::error('Gagal menyimpan profil organisasi ke database', [
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Profil organisasi gagal disimpan. Silakan coba lagi.');
        }

        if ($upload !== null && ! empty($previousPublicId) && $previousPublicId !== $upload['public_id']) {
            if (! $cloudinary->destroy($previousPublicId)) {
                Log::warning('Logo Cloudinary lama gagal dihapus setelah profil organisasi diperbarui', [
                    'public_id' => $previousPublicId,
                ]);
            }
        }

        return redirect()
            ->route('admin.organization-profile.edit')
            ->with('status', 'Profil dan kontak organisasi berhasil diperbarui!');
    }

    /**
     * Hapus aset yang baru diunggah setelah penulisan database gagal.
     */
    protected function discardUploadedAsset(CloudinaryService $cloudinary, string $publicId): void
    {
        if (! $cloudinary->destroy($publicId)) {
            Log::error('Kompensasi gagal: logo Cloudinary sisa operasi yang dibatalkan tidak dapat dihapus', [
                'public_id' => $publicId,
            ]);
        }
    }

    /**
     * Deteksi apakah QueryException disebabkan pelanggaran unique constraint
     * pada kolom singleton_flag (jaminan satu profil organisasi di level DB).
     */
    protected function isSingletonConflict(QueryException $e): bool
    {
        $message = $e->getMessage();

        // MySQL duplicate entry error code
        $info = $e->errorInfo;
        $code = is_array($info) && isset($info[1]) ? (int) $info[1] : null;

        if ($code === 1062) {
            // MySQL: pastikan pesan error mengandung nama constraint/kolom singleton_flag
            return str_contains($message, 'singleton_flag');
        }

        // PostgreSQL / SQLite: cek nama constraint/kolom di pesan error
        return str_contains($message, 'singleton_flag');
    }
}
