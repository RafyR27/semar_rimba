<?php

namespace App\Models;

use Database\Factories\PengurusFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nama', 'nim', 'jabatan', 'divisi_id', 'angkatan', 'is_active'])]
class Pengurus extends Model
{
    /** @use HasFactory<PengurusFactory> */
    use HasFactory;

    protected $table = 'pengurus';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Divisi, $this>
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }
}
