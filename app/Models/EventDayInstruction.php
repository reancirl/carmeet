<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDayInstruction extends Model
{
    protected $fillable = [
        'event_id',
        'arrival_instructions',
        'gate_instructions',
        'items_to_bring',
        'important_notes'
    ];

    /**
     * Get the event that owns the instructions.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
