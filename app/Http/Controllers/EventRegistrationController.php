<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\CarProfile;
use App\Models\CarEventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    /**
     * Show the registration form for an event.
     */
    public function create(Event $event)
    {
        // Get all car profiles for the current user
        $carProfiles = CarProfile::where('user_id', Auth::id())->get();
        
        // Check if user has car profiles before proceeding
        if ($carProfiles->isEmpty()) {
            return redirect()->route('car-profiles.create')
                ->with('warning', 'You need to create a car profile before registering for an event.');
        }
        
        return view('event-registrations.create', compact('event', 'carProfiles'));
    }
    
    /**
     * Store a new event registration.
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'car_profile_id' => 'required|exists:car_profiles,id',
            'crew_name' => 'nullable|string|max:255',
            'class' => 'nullable|string|max:255',
            'notes_to_organizer' => 'nullable|string',
            'agree_to_terms' => 'required|accepted',
        ]);
        
        // Remove agree_to_terms as it's not stored in the database
        unset($validated['agree_to_terms']);
        
        // Add event_id to the validated data
        $validated['event_id'] = $event->id;
        
        // Create the registration
        $registration = CarEventRegistration::create($validated);
        
        return redirect()->route('event-registrations.confirmation', $registration)
            ->with('success', 'Your registration has been submitted and is pending review.');
    }
    
    /**
     * Show the confirmation page after registration.
     */
    public function confirmation(CarEventRegistration $registration)
    {
        return view('event-registrations.confirmation', compact('registration'));
    }
    
    /**
     * List all registrations for the current user.
     */
    public function index()
    {
        // Get car profiles for the current user
        $carProfiles = CarProfile::where('user_id', Auth::id())->pluck('id');
        
        // Get all registrations for these car profiles
        $registrations = CarEventRegistration::whereIn('car_profile_id', $carProfiles)
            ->with(['event', 'carProfile'])
            ->latest()
            ->paginate(10);
            
        return view('event-registrations.index', compact('registrations'));
    }
    
    /**
     * Show details of a specific registration.
     */
    public function show(CarEventRegistration $registration)
    {
        // Check if the registration belongs to the current user
        if ($registration->carProfile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('event-registrations.show', compact('registration'));
    }
}
