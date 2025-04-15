<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['artikel_id', 'unit_pendidikan_id'];

    // Relasi ke Artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }

    // Relasi ke UnitPendidikan
    public function unitPendidikan()
    {
        return $this->belongsTo(UnitPendidikan::class);
    }
}