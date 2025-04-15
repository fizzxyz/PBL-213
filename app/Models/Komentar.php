<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komentar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'artikel_id',
        'isi',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class);
    }

    public function balasan(): HasMany
    {
        return $this->hasMany(Balasan::class, 'komentar_id');
    }

    public function totalBalasan() {
        return $this->balasans()->count();
    }
}
