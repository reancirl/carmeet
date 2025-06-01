<x-public-layout :title="'Registration Details'">
    <div class="flex-grow w-full lg:max-w-4xl mx-auto px-6 lg:px-8 py-8 space-y-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Registration Details</h1>
                <a href="{{ route('event-registrations.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    &larr; Back to My Registrations
                </a>
            </div>
            
            <div class="border-t border-b border-gray-200 py-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Information -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-800 mb-3">Event Information</h2>
                        
                        @if($registration->event)
                            <div class="space-y-2">
                                <p><span class="text-gray-500">Event Name:</span> {{ $registration->event->name }}</p>
                                @if($registration->event->is_multi_day)
                                    <p>
                                        <span class="text-gray-500">Event Type:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Multi-day Event
                                        </span>
                                    </p>
                                    <div class="pl-4 border-l-2 border-purple-200 mt-2 mb-2">
                                        @foreach($registration->event->days as $day)
                                            <p class="mb-1">
                                                <span class="text-gray-500">Day {{ $loop->iteration }}:</span> 
                                                {{ \Carbon\Carbon::parse($day->date)->format('F d, Y') }}, 
                                                {{ date('g:i A', strtotime($day->start_time)) }} - {{ date('g:i A', strtotime($day->end_time)) }}
                                            </p>
                                        @endforeach
                                    </div>
                                @else
                                    <p><span class="text-gray-500">Date:</span> {{ $registration->event->date ? $registration->event->date->format('F d, Y') : 'N/A' }}</p>
                                    <p><span class="text-gray-500">Time:</span> 
                                        {{ $registration->event->start_time ? date('g:i A', strtotime($registration->event->start_time)) : '' }} - 
                                        {{ $registration->event->end_time ? date('g:i A', strtotime($registration->event->end_time)) : '' }}
                                    </p>
                                @endif
                                <p><span class="text-gray-500">Location:</span> 
                                    @if($registration->event->location_name)
                                        {{ $registration->event->location_name }}, 
                                    @endif
                                    @if($registration->event->street || $registration->event->city || $registration->event->state || $registration->event->zip_code)
                                        {{ $registration->event->street }}, {{ $registration->event->city }}, {{ $registration->event->state }} {{ $registration->event->zip_code }}
                                    @endif
                                </p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('public.events.show', $registration->event) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" target="_blank">
                                    View Event Details
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500">Event information is not available.</p>
                        @endif
                    </div>
                    
                    <!-- Registration Status -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-800 mb-3">Registration Status</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-gray-500 mb-1">Current Status:</p>
                                @switch($registration->status)
                                    @case('pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Pending Review
                                        </span>
                                        <p class="text-sm text-gray-500 mt-2">Your registration is being reviewed by the event organizer.</p>
                                        @break
                                    @case('approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Approved
                                        </span>
                                        <p class="text-sm text-gray-500 mt-2">Your registration has been approved. You're all set for the event!</p>
                                        @break
                                    @case('waitlisted')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Waitlisted
                                        </span>
                                        <p class="text-sm text-gray-500 mt-2">You've been placed on the waitlist. We'll notify you if a spot becomes available.</p>
                                        @break
                                    @case('denied')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Denied
                                        </span>
                                        <p class="text-sm text-gray-500 mt-2">Unfortunately, your registration was not approved for this event.</p>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                @endswitch
                            </div>
                            
                            <div>
                                <p class="text-gray-500 mb-1">Payment Status:</p>
                                @if($registration->is_paid)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        <svg class="-ml-1 mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Not Paid
                                    </span>
                                @endif
                                
                                @if($registration->payment_note)
                                    <p class="text-sm text-gray-500 mt-2">{{ $registration->payment_note }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Registration Details -->
            <div>
                <h2 class="text-lg font-medium text-gray-800 mb-4">Registration Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Car Information -->
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-2">Car Information</h3>
                        
                        @if($registration->carProfile)
                            <div class="space-y-2">
                                <p><span class="text-gray-500">Make & Model:</span> {{ $registration->carProfile->year }} {{ $registration->carProfile->make }} {{ $registration->carProfile->model }}</p>
                                <p><span class="text-gray-500">Color:</span> {{ $registration->carProfile->color }}</p>
                                @if($registration->carProfile->trim)
                                    <p><span class="text-gray-500">Trim:</span> {{ $registration->carProfile->trim }}</p>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500">Car information is not available.</p>
                        @endif
                    </div>
                    
                    <!-- Registration Info -->
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-2">Additional Information</h3>
                        
                        <div class="space-y-2">
                            @if($registration->class)
                                <p><span class="text-gray-500">Class:</span> {{ $registration->class }}</p>
                            @endif
                            
                            @if($registration->crew_name)
                                <p><span class="text-gray-500">Crew Name:</span> {{ $registration->crew_name }}</p>
                            @endif
                            
                            @if($registration->notes_to_organizer)
                                <p><span class="text-gray-500">Notes to Organizer:</span></p>
                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $registration->notes_to_organizer }}</p>
                            @endif
                            
                            <p><span class="text-gray-500">Registration Date:</span> {{ $registration->created_at->format('F d, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
