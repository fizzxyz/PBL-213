<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yayasan extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
        'website',
        'logo',
        'sejarah',
        'tentang',
        'vision',
    ];
}
