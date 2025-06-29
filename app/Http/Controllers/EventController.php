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
        $validated = $request->validated();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        } else {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['slug']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $count = 2;
        while (Event::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        $data = $validated + ['organizer_id' => auth()->id()];

        // Extract event_days data if it's a multi-day event
        $eventDays = null;
        if (!empty($data['is_multi_day']) && isset($data['event_days'])) {
            $eventDays = $data['event_days'];
            unset($data['event_days']);
        }

        // Create the event
        $event = Event::create($data);

        // Save event days if it's a multi-day event
        if (!empty($data['is_multi_day']) && $eventDays) {
            foreach ($eventDays as $day) {
                $event->days()->create($day);
            }
        }

        $this->images->upload($event, $request->file('image'));

        // redirect to the new created event
        return to_route('events.show', $event)->with('success', 'Event created successfully');
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
        $validated = $request->validated();
        
        // Handle slug update
        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        } else {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['slug']);
        }

        // Ensure slug is unique, but not for the current event
        if (strtolower($validated['slug']) !== strtolower($event->slug)) {
            $originalSlug = $validated['slug'];
            $count = 2;
            while (Event::where('slug', $validated['slug'])->where('id', '!=', $event->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $data = $validated;

        // Extract event_days data if it's a multi-day event
        $eventDays = null;
        if (!empty($data['is_multi_day']) && isset($data['event_days'])) {
            $eventDays = $data['event_days'];
            unset($data['event_days']);
        }

        // Update the event
        $event->update($data);

        // Update event days if it's a multi-day event
        if (!empty($data['is_multi_day']) && $eventDays) {
            // Delete existing days
            $event->days()->delete();

            // Create new days
            foreach ($eventDays as $day) {
                $event->days()->create([
                    'date' => $day['date'],
                    'start_time' => $day['start_time'],
                    'end_time' => $day['end_time'],
                ]);
            }
        } elseif (empty($data['is_multi_day'])) {
            // If switching from multi-day to single-day, remove all days
            $event->days()->delete();
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $this->images->upload($event, $request->file('image'));
        }

        return redirect()->back()->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        $this->images->delete($event);
        $event->delete();

        return to_route('events.index')->with('success', 'Event deleted successfully');
    }
}
