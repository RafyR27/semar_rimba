<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'deskripsi', 'is_active'])]
class Divisi extends Model
{
    protected $table = 'divisis';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class);
    }
}
