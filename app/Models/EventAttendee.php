<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    protected $fillable = [
        'event_id',
        'attendee_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function attendee()
    {
        return $this->belongsTo(User::class, 'attendee_id');
    }
}