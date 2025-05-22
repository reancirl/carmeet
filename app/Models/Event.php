<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'host_id',
        'name',
        'date',
        'start_time',
        'end_time',
        'description',
        'street',
        'city',
        'state',
        'zip_code',
        'location_name',
        'image'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees', 'event_id', 'attendee_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return null;
    }
}
