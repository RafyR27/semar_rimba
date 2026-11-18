<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\BeritaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $judul
 * @property string $slug
 * @property string $konten
 * @property string|null $thumbnail_url
 * @property string|null $thumbnail_public_id
 * @property CarbonInterface|null $tanggal_terbit
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static> published()
 * @method static Builder<static> latestPublished()
 */
#[Fillable([
    'judul',
    'slug',
    'konten',
    'thumbnail_url',
    'thumbnail_public_id',
    'tanggal_terbit',
    'is_published',
])]
class Berita extends Model
{
    /** @use HasFactory<BeritaFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_terbit' => 'date',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include published news.
     *
     * @param  Builder<Berita>  $query
     * @return Builder<Berita>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to order news by publication date, newest first.
     *
     * @param  Builder<Berita>  $query
     * @return Builder<Berita>
     */
    public function scopeLatestPublished(Builder $query): Builder
    {
        return $query->orderByRaw('tanggal_terbit IS NULL')
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    /**
     * Get the publication date used for display purposes.
     */
    public function publicationDate(): ?CarbonInterface
    {
        return $this->tanggal_terbit ?? $this->created_at;
    }
}
