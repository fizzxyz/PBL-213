<?php

namespace App\Models;

use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;

class Galeri extends Model
{
    use HasSlug;
    protected $fillable = [
        'title',
        'slug',
        'path_image',
        'text',
        'unit_pendidikan_id',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('title')
        ->saveSlugsTo('slug');
    }

    public function unitPendidikan()
    {
        return $this->belongsTo(UnitPendidikan::class);
    }
}
