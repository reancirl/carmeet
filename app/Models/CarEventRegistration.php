<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarEventRegistration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_profile_id',
        'event_id',
        'status',
        'crew_name',
        'class',
        'notes_to_organizer',
        'is_paid',
        'payment_note',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_paid' => 'boolean',
    ];

    /**
     * Get the car profile associated with the registration.
     */
    public function carProfile()
    {
        return $this->belongsTo(CarProfile::class);
    }

    /**
     * Get the event associated with the registration.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
