<?php

namespace App\Models;

use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use App\Models\Calendar;

class UnitPendidikan extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = ['nama', 'alamat', 'about', 'slug', 'image', 'logo', 'visi', 'misi'];

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

    // Relasi ke Artikel
    public function artikels()
    {
        return $this->belongsToMany(Artikel::class, 'tags');
    }

    // Relasi ke Penerimaan
    public function penerimaans()
    {
        return $this->hasMany(Penerimaan::class);
    }

    // Relasi ke Navbar
    public function navbars()
    {
        return $this->hasMany(Navbar::class);
    }

    // Relasi ke Calendar
    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nama')
            ->saveSlugsTo('slug');
    }

}