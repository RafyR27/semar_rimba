<?php

namespace App\Models;

use Database\Factories\HeroBannerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string $image_url
 * @property string $image_public_id
 * @property string|null $button_text
 * @property string|null $button_url
 * @property bool $is_active
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static> active()
 * @method static Builder<static> ordered()
 */
#[Fillable([
    'title',
    'subtitle',
    'description',
    'image_url',
    'image_public_id',
    'button_text',
    'button_url',
    'is_active',
    'order',
])]
class HeroBanner extends Model
{
    /** @use HasFactory<HeroBannerFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active banners.
     *
     * @param  Builder<HeroBanner>  $query
     * @return Builder<HeroBanner>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order banners by designated order.
     *
     * @param  Builder<HeroBanner>  $query
     * @return Builder<HeroBanner>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'desc');
    }

    /**
     * Determine if this banner has a valid Call To Action button.
     */
    public function hasButton(): bool
    {
        return ! empty($this->button_text) && ! empty($this->button_url);
    }
}
