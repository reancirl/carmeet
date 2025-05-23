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
            $events = Event::with('host')->get();
        } else {
            $events = Event::with('host')
                           ->where('host_id', auth()->id())
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
        $data = $request->validated() + ['host_id' => auth()->id()];
        $event = Event::create($data);

        $this->images->upload($event, $request->file('image'));

        return to_route('events.index')
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

        $this->images->upload($event, $request->file('image'));

        $event->update($data);

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
