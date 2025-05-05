<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerimaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama', 'dibuka_pada', 'ditutup_pada', 'deskripsi', 'biaya', 'unit_pendidikan_id'
    ];

    // Relasi ke Pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function unitPendidikan()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_pendidikan_id');
    }

    public function isOpen() {
        $now = now();
        return $now->between($this->dibuka_pada, $this->ditutup_pada);
    }
}