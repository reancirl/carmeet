<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'host_id',
        'name',
        'date',
        'time',
        'description',
        'location',
        'zip_code'
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees', 'event_id', 'attendee_id');
    }
}
