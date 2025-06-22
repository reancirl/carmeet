<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Rules\UsZipCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\EventImageService;
use App\Models\User;

class EventController extends Controller
{
    protected EventImageService $images;

    public function __construct(EventImageService $images)
    {
        $this->authorizeResource(Event::class, 'event');
        $this->images = $images;
    }

    public function index()
{
    if (auth()->user()->role === 'admin') {
        $events = Event::with(['organizer', 'registrations', 'attendees', 'days'])->get();
    } else {
        $events = Event::with(['organizer', 'registrations', 'attendees', 'days'])
                       ->where('organizer_id', auth()->id())
                       ->get();
    }
    
    return view('events.index', compact('events'));
}

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated() + ['organizer_id' => auth()->id()];
        
        // Extract event_days data if it's a multi-day event
        $eventDays = null;
        if (!empty($data['is_multi_day']) && isset($data['event_days'])) {
            $eventDays = $data['event_days'];
            unset($data['event_days']);
        }
        
        $event = Event::create($data);

        // Save event days if it's a multi-day event
        if (!empty($data['is_multi_day']) && $eventDays) {
            foreach ($eventDays as $day) {
                $event->days()->create($day);
            }
        }

        $this->images->upload($event, $request->file('image'));

        // redirect to the new created event
        return to_route('events.show', $event)
               ->with('success', 'Event created successfully');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();
        
        // Extract event_days data if it's a multi-day event
        $eventDays = null;
        if (!empty($data['is_multi_day']) && isset($data['event_days'])) {
            $eventDays = $data['event_days'];
            unset($data['event_days']);
        }

        $this->images->upload($event, $request->file('image'));

        $event->update($data);

        // Handle multi-day event updates
        if (!empty($data['is_multi_day']) && $eventDays) {
            // Keep track of processed day IDs
            $processedDayIds = [];
            
            foreach ($eventDays as $day) {
                if (!empty($day['id'])) {
                    // Update existing day
                    $eventDay = $event->days()->find($day['id']);
                    if ($eventDay) {
                        $eventDay->update([
                            'date' => $day['date'],
                            'start_time' => $day['start_time'],
                            'end_time' => $day['end_time']
                        ]);
                        $processedDayIds[] = $eventDay->id;
                    }
                } else {
                    // Create new day
                    $newDay = $event->days()->create([
                        'date' => $day['date'],
                        'start_time' => $day['start_time'],
                        'end_time' => $day['end_time']
                    ]);
                    $processedDayIds[] = $newDay->id;
                }
            }
            
            // Delete days that weren't updated
            $event->days()->whereNotIn('id', $processedDayIds)->delete();
        } else {
            // If switching from multi-day to single-day, remove all days
            $event->days()->delete();
        }

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        $this->images->delete($event);
        $event->delete();

        return to_route('events.index')
               ->with('success', 'Event deleted successfully');
    }
}