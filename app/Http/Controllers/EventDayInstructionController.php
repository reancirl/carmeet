<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDayInstruction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventDayInstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EventDayInstruction $eventDayInstruction)
    {
        //
    }

    /**
     * Show the form for editing the event day instructions.
     */
    public function edit(Event $event)
    {
        $this->authorize('manageDayInstructions', $event);
        
        $instructions = $event->dayInstructions ?? new EventDayInstruction(['event_id' => $event->id]);
        
        return view('events.day-instructions.edit', [
            'event' => $event,
            'instructions' => $instructions
        ]);
    }

    /**
     * Update the event day instructions in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('manageDayInstructions', $event);
        
        $validated = $request->validate([
            'arrival_instructions' => 'nullable|string|max:1000',
            'gate_instructions' => 'nullable|string|max:1000',
            'items_to_bring' => 'nullable|string|max:1000',
            'important_notes' => 'nullable|string|max:1000',
        ]);
        
        $instructions = $event->dayInstructions()->updateOrCreate(
            ['event_id' => $event->id],
            $validated
        );
        
        return redirect()
            ->route('events.show', $event->slug)
            ->with('success', 'Event day instructions updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventDayInstruction $eventDayInstruction)
    {
        //
    }
}
