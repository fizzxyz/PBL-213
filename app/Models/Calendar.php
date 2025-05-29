<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'unit_pendidikan_id'
    ];

    /**
     * Get the unit pendidikan that owns the calendar.
     */
    public function unitPendidikan()
    {
        return $this->belongsTo(UnitPendidikan::class);
    }
}
