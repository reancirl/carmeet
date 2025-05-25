<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'make',
        'model',
        'year',
        'trim',
        'color',
        'mods',
        'plate',
        'description',
        'image_urls',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'image_urls' => 'array',
        'year' => 'integer',
    ];

    /**
     * Get the user that owns the car profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event registrations for this car profile.
     */
    public function registrations()
    {
        return $this->hasMany(CarEventRegistration::class);
    }
}
