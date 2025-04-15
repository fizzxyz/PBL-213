<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_transaksi', 'user_id', 'pendaftaran_id',
        'total', 'is_paid', 'metode_pembayaran', 'bukti_pembayaran'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Pendaftaran
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function is_active(): bool
    {
        return $this->is_paid && $this->ended_at->isFuture();
    }
}