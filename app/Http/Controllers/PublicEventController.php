<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::when($request->zip_code, fn($q, $zip) =>
            $q->where('zip_code', $zip)
        )->get();

        return view('welcome', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.details', compact('event'));
    }
}
