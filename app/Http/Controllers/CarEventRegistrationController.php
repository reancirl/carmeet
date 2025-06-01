<?php

namespace App\Http\Controllers;

use App\Models\CarEventRegistration;
use Illuminate\Http\Request;

class CarEventRegistrationController extends Controller
{
    /**
     * Get the detailed information about a registration for the modal view
     */
    public function getDetails(CarEventRegistration $registration)
    {
        // Authorization check - only allow organizers or admins
        $this->authorize('view', $registration->event);
        
        // Return the data needed for the modal
        return response()->json([
            'registration' => $registration,
            'car' => $registration->carProfile,
            'user' => $registration->carProfile->user
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
            'status' => 'required|string|in:pending,approved,denied,waitlist',
        ]);
        
        $registration->update([
            'status' => $validated['status']
        ]);
        
        return redirect()->back()->with('success', 'Registration status updated successfully.');
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
            'payment_note' => $validated['payment_note']
        ]);
        
        return redirect()->back()->with('success', 'Payment information updated successfully.');
    }
}
