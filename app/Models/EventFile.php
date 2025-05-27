<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFile extends Model
{
    protected $fillable = [
        'event_id',
        'file_name',
        'file_url',
        'description',
        'visibility'
    ];

    /**
     * Get the event that owns the file.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
