<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDay extends Model
{
    protected $fillable = [
        'event_id',
        'date',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the event that owns the day.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
