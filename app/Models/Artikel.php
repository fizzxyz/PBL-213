<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Artikel extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'judul', 'user_id', 'category_id', 'slug', 'thumbnail', 'isi'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Komentar
    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    // Relasi ke Tag
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('judul')
        ->saveSlugsTo('slug');
    }
}