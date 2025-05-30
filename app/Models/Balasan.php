<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balasan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'komentar_id',
        'isi',
        'guest_name',
        'guest_email',
    ];

    public function komentar(): BelongsTo
    {
        return $this->belongsTo(Komentar::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
