<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'penerimaan_id', 'nomor_pendaftaran',
        'nama_lengkap', 'usia', 'alamat', 'unit_pendidikan_id', 'status_pendaftaran'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Penerimaan
    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class);
    }

    // Relasi ke UnitPendidikan
    public function unitPendidikan()
    {
        return $this->belongsTo(UnitPendidikan::class);
    }

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    //Auto generate nomor pendaftaran
    protected static function boot() {
        parent::boot();
        static::creating(function ($pendaftaran) {
            $pendaftaran->nomor_pendaftaran = 'PD-' . now()->format('Ymd') . '-' . Str::random(6);
        });
    }
}