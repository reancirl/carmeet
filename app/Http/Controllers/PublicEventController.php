<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        // fetch and categorize your events however you like...
        $featuredEvent = Event::first();
        $weekendEvents = Event::get();
        $nearbyEvents = Event::get();
        $upcomingEvents = Event::get();

        return view('welcome', compact('featuredEvent', 'weekendEvents', 'nearbyEvents', 'upcomingEvents'));
    }

    public function show(Event $event)
    {
        return view('events.details', compact('event'));
    }
}
