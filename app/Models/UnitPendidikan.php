<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitPendidikan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama', 'alamat', 'about'];

    // Relasi ke User
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke Pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // Relasi ke Tag
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}