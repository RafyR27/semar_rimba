<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class CloudinaryService
{
    protected ?Cloudinary $cloudinary = null;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize Cloudinary client directly from CLOUDINARY_URL.
     */
    protected function initialize(): void
    {
        $url = config('cloudinary.url');

        if (! empty($url)) {
            try {
                $this->cloudinary = new Cloudinary($url);
            } catch (Throwable $e) {
                $this->cloudinary = null;
                Log::warning('Format CLOUDINARY_URL tidak valid', [
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Check whether Cloudinary has been properly configured.
     */
    public function isConfigured(): bool
    {
        return $this->cloudinary !== null;
    }

    /**
     * Upload an uploaded file to Cloudinary.
     *
     * @param  UploadedFile  $file  The file uploaded from request
     * @param  string  $folder  Target folder name in Cloudinary
     * @return array{public_id: string, secure_url: string}
     *
     * @throws RuntimeException
     */
    public function upload(UploadedFile $file, string $folder = 'hero_banners'): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Cloudinary belum dikonfigurasi. Harap atur kredensial CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME di file .env.');
        }

        try {
            $response = $this->cloudinary?->uploadApi()->upload(
                $file->getRealPath(),
                [
                    'folder' => $folder,
                    'resource_type' => 'image',
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ]
            );

            /** @var array<string, mixed> $data */
            $data = $response?->getArrayCopy() ?? [];

            if (! isset($data['public_id']) || ! isset($data['secure_url'])) {
                throw new RuntimeException('Respons dari Cloudinary tidak memiliki atribut public_id atau secure_url.');
            }

            return [
                'public_id' => (string) $data['public_id'],
                'secure_url' => (string) $data['secure_url'],
            ];
        } catch (Throwable $e) {
            Log::error('Gagal mengunggah gambar ke Cloudinary', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
            ]);

            throw new RuntimeException('Gagal mengunggah gambar ke Cloudinary: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete an asset from Cloudinary by its public ID.
     *
     * @param  string|null  $publicId  The public ID of the asset
     */
    public function destroy(?string $publicId): bool
    {
        if (empty($publicId) || ! $this->isConfigured()) {
            return false;
        }

        try {
            $response = $this->cloudinary?->uploadApi()->destroy($publicId, [
                'resource_type' => 'image',
                'invalidate' => true,
            ]);

            /** @var array<string, mixed> $data */
            $data = $response?->getArrayCopy() ?? [];
            $resultStatus = isset($data['result']) ? (string) $data['result'] : '';

            return in_array($resultStatus, ['ok', 'not found'], true);
        } catch (Throwable $e) {
            Log::warning('Gagal menghapus gambar dari Cloudinary', [
                'public_id' => $publicId,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
