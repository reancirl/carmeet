<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // for whereRaw

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Featured (already correct)
        $featuredEvents = Event::where('is_featured', true)
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->get();

        // 1) Weekend = Saturday (weekday 5) or Sunday (weekday 6), date ≥ today
        $weekendEvents = Event::whereDate('date', '>=', $today)
            ->whereRaw('WEEKDAY(`date`) >= ?', [5])
            ->orderBy('date')
            ->get();

        // 2) Nearby (you can plug in your own geofencing here later)
        $nearbyEvents = Event::get();

        // 3) Upcoming = all future (and today’s) events
        $upcomingEvents = Event::whereDate('date', '>=', $today)
            ->orderBy('date')
            ->get();

        return view('welcome', compact(
            'featuredEvents',
            'weekendEvents',
            'nearbyEvents',
            'upcomingEvents'
        ));
    }

    public function show(Event $event)
    {
        return view('events.details', compact('event'));
    }
}