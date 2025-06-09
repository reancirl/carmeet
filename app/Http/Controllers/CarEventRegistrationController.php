<?php

namespace App\Http\Controllers;

use App\Models\CarEventRegistration;
use Illuminate\Http\Request;

class CarEventRegistrationController extends Controller
{
    /**
     * Show the registration details
     */
    public function show(CarEventRegistration $registration)
    {
        // Authorization check - only allow organizers or admins
        $this->authorize('view', $registration->event);
        
        return view('car-registrants.details', [
            'registration' => $registration->load(['carProfile.user', 'event'])
        ]);
    }
    
    /**
     * Show the form to edit the registration status
     */
    public function editStatus(CarEventRegistration $registration)
    {
        // Authorization check - only allow organizers or admins
        $this->authorize('update', $registration->event);
        
        return view('car-registrants.edit-status', [
            'registration' => $registration->load(['carProfile.user', 'event'])
        ]);
    }
    
    /**
     * Update the status of a registration
     */
    public function updateStatus(Request $request, CarEventRegistration $registration)
    {
        
        // Authorization check - only allow organizers or admins
        $this->authorize('update', $registration->event);
        
        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,denied,waitlisted',
        ]);
        
        $registration->update([
            'status' => $validated['status']
        ]);
        
        return redirect()
            ->route('car-registrants.details', $registration)
            ->with('success', 'Registration status updated successfully.');
    }
    
    /**
     * Show the form to edit the payment information
     */
    public function editPayment(CarEventRegistration $registration)
    {
        // Authorization check - only allow organizers or admins
        $this->authorize('update', $registration->event);
        
        return view('car-registrants.edit-payment', [
            'registration' => $registration->load(['carProfile.user', 'event'])
        ]);
    }
    
    /**
     * Update the payment information of a registration
     */
    public function updatePayment(Request $request, CarEventRegistration $registration)
    {
        // Authorization check - only allow organizers or admins
        $this->authorize('update', $registration->event);
        
        $validated = $request->validate([
            'is_paid' => 'required|boolean',
            'payment_note' => 'nullable|string|max:500',
        ]);
        
        $registration->update([
            'is_paid' => $validated['is_paid'],
            'payment_note' => $validated['payment_note'] ?? null
        ]);
        
        return redirect()
            ->route('car-registrants.details', $registration)
            ->with('success', 'Payment information updated successfully.');
    }
}