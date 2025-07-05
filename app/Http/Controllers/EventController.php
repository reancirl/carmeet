<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\EventImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        // Generate & dedupe slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }
        $original = $validated['slug'];
        for ($i = 2; Event::where('slug', $validated['slug'])->exists(); $i++) {
            $validated['slug'] = "{$original}-{$i}";
        }

        // 1) Only admins can feature
        $validated['is_featured'] = auth()->user()->role === 'admin' && $request->has('is_featured');

        // 2) Prevent past events from being featured
        if ($validated['is_featured'] && Carbon::parse($validated['date'])->lt(Carbon::today())) {
            return back()
                ->withInput()
                ->withErrors(['is_featured' => 'Only today’s or future events can be featured.']);
        }

        // Prepare multi-day data
        $eventDays = null;
        if (!empty($validated['is_multi_day']) && isset($validated['event_days'])) {
            $eventDays = $validated['event_days'];
            unset($validated['event_days']);
        }

        // Merge organizer & create
        $validated['organizer_id'] = auth()->id();
        $event = Event::create($validated);

        if (!empty($validated['is_multi_day']) && $eventDays) {
            foreach ($eventDays as $day) {
                $event->days()->create($day);
            }
        }

        $this->images->upload($event, $request->file('image'));

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

        // Slug regen & dedupe (excluding current)
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }
        if (strcasecmp($validated['slug'], $event->slug) !== 0) {
            $original = $validated['slug'];
            for ($i = 2; Event::where('slug', $validated['slug'])->where('id', '!=', $event->id)->exists(); $i++) {
                $validated['slug'] = "{$original}-{$i}";
            }
        }

        // 1) Only admins can feature
        $validated['is_featured'] = auth()->user()->role === 'admin' && $request->has('is_featured');

        // 2) Prevent past events from being featured
        //    → only for single-day events (no multi-day)
        if (empty($validated['is_multi_day']) && $validated['is_featured'] && Carbon::parse($validated['date'])->lt(Carbon::today())) {
            return back()
                ->withInput()
                ->withErrors([
                    'is_featured' => 'Only today’s or future events can be featured.',
                ]);
        }

        // Multi-day extraction
        $eventDays = null;
        if (!empty($validated['is_multi_day']) && isset($validated['event_days'])) {
            $eventDays = $validated['event_days'];
            unset($validated['event_days']);
        }

        $event->update($validated);

        // Sync days
        if (!empty($validated['is_multi_day']) && $eventDays) {
            $event->days()->delete();
            foreach ($eventDays as $day) {
                $event->days()->create([
                    'date' => $day['date'],
                    'start_time' => $day['start_time'],
                    'end_time' => $day['end_time'],
                ]);
            }
        } elseif (empty($validated['is_multi_day'])) {
            $event->days()->delete();
        }

        if ($request->hasFile('image')) {
            $this->images->upload($event, $request->file('image'));
        }

        return back()->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        $this->images->delete($event);
        $event->delete();

        return to_route('events.index')->with('success', 'Event deleted successfully');
    }
}
