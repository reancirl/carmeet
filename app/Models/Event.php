<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    /**
     * Get the route key name for Laravel's route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    protected $fillable = [
        'organizer_id',
        'name',
        'slug',
        'date',
        'start_time',
        'end_time',
        'is_multi_day',
        'description',
        'street',
        'city',
        'state',
        'zip_code',
        'location_name',
        'image',
        'is_featured',
    ];

    protected $casts = [
        'date'       => 'date',
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
        'is_multi_day' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($event) {
            if ($event->isDirty('name')) {
                $event->slug = \Illuminate\Support\Str::slug($event->name);
            }
        });
    }
    
    /**
     * Get the registrations for the event.
     */
    public function registrations()
    {
        return $this->hasMany(CarEventRegistration::class);
    }

    /**
     * Get the files associated with the event.
     */
    public function files()
    {
        return $this->hasMany(EventFile::class);
    }
    
    /**
     * Get the days for a multi-day event.
     */
    public function days()
    {
        return $this->hasMany(EventDay::class);
    }
     // Get raw EventAttendee records
    public function attendeeRegistrations()
    {
        return $this->hasMany(EventAttendee::class);
    }
    
    /**
     * Get the event day instructions for the event.
     */
    public function dayInstructions()
    {
        return $this->hasOne(EventDayInstruction::class);
    }
}