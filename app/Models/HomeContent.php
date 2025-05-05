<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_text',
        'hero_sm_title',
        'hero_image',
        'card_title',
        'card_text',
        'galeri_title',
        'galeri_sm_title',
        'video_title',
        'video_sm_title',
        'pengantar_title',
        'pengantar_sm_title',
        'pengantar_text',
        'pengantar_image',
        'pengantar_sm_text1',
        'pengantar_sm_text2',
    ];
}
