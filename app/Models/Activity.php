<?php

namespace App\Models;

use Database\Factories\ActivityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $title
 * @property string $slug
 * @property string $category
 * @property string|null $location
 * @property Carbon|null $event_date
 * @property string $description
 * @property string $image_url
 * @property string $image_public_id
 * @property string|null $document_path
 * @property string|null $document_original_name
 * @property string|null $document_mime_type
 * @property int|null $document_size
 * @property string $status
 * @property bool $is_active
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static> active()
 * @method static Builder<static> ordered()
 */
#[Fillable([
    'user_id',
    'title',
    'slug',
    'category',
    'location',
    'event_date',
    'description',
    'image_url',
    'image_public_id',
    'document_path',
    'document_original_name',
    'document_mime_type',
    'document_size',
    'status',
    'is_active',
    'order',
])]
class Activity extends Model
{
    /** @use HasFactory<ActivityFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'document_size' => 'integer',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Determine whether the activity has an attached supporting document.
     */
    public function hasDocument(): bool
    {
        return ! empty($this->document_path);
    }

    /**
     * Format the attached document size into a human-readable string.
     */
    public function formattedDocumentSize(): ?string
    {
        if ($this->document_size === null) {
            return null;
        }

        if ($this->document_size >= 1048576) {
            return number_format($this->document_size / 1048576, 2).' MB';
        }

        return max(1, (int) round($this->document_size / 1024)).' KB';
    }

    /**
     * Scope a query to only include active/published activities.
     *
     * @param  Builder<Activity>  $query
     * @return Builder<Activity>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order activities by designated order and newest event date.
     *
     * @param  Builder<Activity>  $query
     * @return Builder<Activity>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order', 'asc')->orderBy('event_date', 'desc')->orderBy('id', 'desc');
    }

    /**
     * Get the user that owns the activity.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
