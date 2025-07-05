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

        // Always eager-load days (we’ll filter them in the queries below)
        $base = Event::with(['days']);

        //
        // 1) Featured events: is_featured AND (single date ≥ today OR any day ≥ today)
        //
        $featuredEvents = (clone $base)
            ->where('is_featured', true)
            ->where(function ($q) use ($today) {
                $q->whereDate('date', '>=', $today)->orWhereHas('days', fn($q2) => $q2->whereDate('date', '>=', $today));
            })
            ->get()
            ->sortBy(fn(Event $e) => $e->is_multi_day && $e->days->isNotEmpty() ? $e->days->min('date') : $e->date);

        //
        // 2) Weekend events: any occurrence on Sat/Sun AND date ≥ today
        //
        $weekendEvents = (clone $base)
            ->where(function ($q) {
                $q->whereRaw('WEEKDAY(`date`) >= ?', [5])->orWhereHas('days', fn($q2) => $q2->whereRaw('WEEKDAY(`date`) >= ?', [5]));
            })
            ->where(function ($q) use ($today) {
                $q->whereDate('date', '>=', $today)->orWhereHas('days', fn($q2) => $q2->whereDate('date', '>=', $today));
            })
            ->get()
            ->sortBy(fn(Event $e) => $e->is_multi_day && $e->days->isNotEmpty() ? $e->days->min('date') : $e->date);

        //
        // 3) Nearby events: all, but still load days for display
        //
        $nearbyEvents = (clone $base)->get();

        //
        // 4) Upcoming events: any occurrence ≥ today
        //
        $upcomingEvents = (clone $base)
            ->where(function ($q) use ($today) {
                $q->whereDate('date', '>=', $today)->orWhereHas('days', fn($q2) => $q2->whereDate('date', '>=', $today));
            })
            ->get()
            ->sortBy(fn(Event $e) => $e->is_multi_day && $e->days->isNotEmpty() ? $e->days->min('date') : $e->date);

        return view('welcome', compact('featuredEvents', 'weekendEvents', 'nearbyEvents', 'upcomingEvents'));
    }

    public function show(Event $event)
    {
        return view('events.details', compact('event'));
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }
}
