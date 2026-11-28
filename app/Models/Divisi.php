<?php

namespace App\Models;

use Database\Factories\DivisiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'deskripsi', 'is_active'])]
class Divisi extends Model
{
    /** @use HasFactory<DivisiFactory> */
    use HasFactory;

    protected $table = 'divisis';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasMany<Pengurus, $this>
     */
    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class);
    }
}
