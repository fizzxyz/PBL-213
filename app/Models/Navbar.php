<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    protected $fillable = [
        'unit_pendidikan_id', 'cta_text', 'cta_link'
    ];

    public function unitPendidikan()
    {
        return $this->belongsTo(UnitPendidikan::class);
    }
}
