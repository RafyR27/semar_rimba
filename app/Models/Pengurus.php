<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nama', 'nim', 'jabatan', 'divisi_id', 'angkatan', 'is_active'])]
class Pengurus extends Model
{
    protected $table = 'pengurus';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }
}
