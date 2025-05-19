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
        'time',
        'description',
        'location',
        'zip_code',
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

    public function getFormattedDateTimeAttribute(): string
    {
        $datePart = $this->date->format('Y-m-d');
        $dt = Carbon::parse("{$datePart} {$this->time}");

        return $dt->format('Y-m-d g:ia');
    }
}
