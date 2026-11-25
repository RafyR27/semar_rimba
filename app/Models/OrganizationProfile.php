<?php

namespace App\Models;

use Database\Factories\OrganizationProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nama_organisasi
 * @property string $deskripsi_singkat
 * @property string $sejarah
 * @property string $visi
 * @property string $misi
 * @property string $alamat
 * @property string|null $email
 * @property string|null $telepon
 * @property string|null $whatsapp
 * @property string|null $instagram_url
 * @property string|null $tiktok_url
 * @property string|null $google_maps_url
 * @property string|null $logo_url
 * @property string|null $logo_public_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'nama_organisasi',
    'deskripsi_singkat',
    'sejarah',
    'visi',
    'misi',
    'alamat',
    'email',
    'telepon',
    'whatsapp',
    'instagram_url',
    'tiktok_url',
    'google_maps_url',
    'logo_url',
    'logo_public_id',
])]
class OrganizationProfile extends Model
{
    /** @use HasFactory<OrganizationProfileFactory> */
    use HasFactory;

    /**
     * The default organization name used when no profile record exists yet.
     */
    public const DEFAULT_NAME = 'SEMAR RIMBA';

    /**
     * Get the single organization profile record, if it already exists.
     */
    public static function current(): ?self
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable('organization_profiles')) {
            return null;
        }

        return static::query()->orderBy('id')->first();
    }

    /**
     * Get the organization name with a safe fallback for public pages.
     */
    public function displayName(): string
    {
        $name = trim($this->nama_organisasi);

        return $name !== '' ? $name : self::DEFAULT_NAME;
    }

    /**
     * Get the logo URL with a fallback to the bundled site logo.
     */
    public function logoUrl(): string
    {
        return $this->logo_url ?: asset('images/logo.png');
    }

    /**
     * Split the mission text into individual mission statements.
     *
     * @return array<int, string>
     */
    public function missionLines(): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $this->misi) ?: [];

        $lines = array_values(array_filter(
            array_map(static fn (string $line): string => trim($line), $lines),
            static fn (string $line): bool => $line !== '',
        ));

        return $lines;
    }

    /**
     * Split the mission text into a title and optional description per line.
     *
     * Each line uses the "Judul: Penjelasan" format; the description is optional.
     *
     * @return array<int, array{judul: string, deskripsi: string|null}>
     */
    public function missionItems(): array
    {
        return array_map(static function (string $line): array {
            $parts = explode(':', $line, 2);

            $judul = trim($parts[0]);
            $deskripsi = isset($parts[1]) ? trim($parts[1]) : '';

            return [
                'judul' => $judul,
                'deskripsi' => $deskripsi !== '' ? $deskripsi : null,
            ];
        }, $this->missionLines());
    }
}
