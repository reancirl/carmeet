<x-public-layout :title="'Registration Pending - ' . $registration->event->name">
    <div class="flex-grow w-full lg:max-w-4xl mx-auto px-6 lg:px-8 py-8 space-y-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-center text-gray-900 dark:text-gray-100">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            <div class="flex items-center justify-center mb-6">
                @if($registration->status === 'approved')
                    <div class="bg-green-100 rounded-full p-3 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                @elseif($registration->status === 'denied')
                    <div class="bg-red-100 rounded-full p-3 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                @elseif($registration->status === 'waitlisted')
                    <div class="bg-blue-100 rounded-full p-3 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @else
                    <div class="bg-yellow-100 rounded-full p-3 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                @endif
            </div>
            
            <div class="mb-6">
                @if($registration->status === 'approved')
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Registration Approved!</h1>
                    <p class="text-gray-600 dark:text-gray-400">Your registration for <span class="font-semibold">{{ $registration->event->name }}</span> has been approved. You're all set to attend!</p>
                    <p class="text-green-600 font-medium mt-2">✅ Registration submitted! Watch your email for updates.</p>
                @elseif($registration->status === 'denied')
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Registration Denied</h1>
                    <p class="text-gray-600 dark:text-gray-400">We're sorry, but your registration for <span class="font-semibold">{{ $registration->event->name }}</span> was not approved.</p>
                @elseif($registration->status === 'waitlisted')
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Registration Waitlisted</h1>
                    <p class="text-gray-600 dark:text-gray-400">Your registration for <span class="font-semibold">{{ $registration->event->name }}</span> has been placed on the waitlist. We'll notify you if a spot becomes available.</p>
                @else
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Registration Pending Review</h1>
                    <p class="text-gray-600 dark:text-gray-400">Your registration for <span class="font-semibold">{{ $registration->event->name }}</span> has been submitted successfully and is awaiting approval from the event organizer.</p>
                    <p class="text-green-600 font-medium mt-2">✅ Registration submitted! Watch your email for updates.</p>
                @endif
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg mb-6 text-left">
                <h2 class="text-lg font-medium text-gray-800 mb-3">Registration Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Car</p>
                        <p class="font-medium">{{ $registration->carProfile->year }} {{ $registration->carProfile->make }} {{ $registration->carProfile->model }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div>
                    
                    @if($registration->crew_name)
                    <div>
                        <p class="text-sm text-gray-500">Crew</p>
                        <p class="font-medium">{{ $registration->crew_name }}</p>
                    </div>
                    @endif
                    
                    @if($registration->class)
                    <div>
                        <p class="text-sm text-gray-500">Class</p>
                        <p class="font-medium">{{ $registration->class }}</p>
                    </div>
                    @endif
                </div>
                
                @if($registration->notes_to_organizer)
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Notes to Organizer</p>
                    <p class="mt-1">{{ $registration->notes_to_organizer }}</p>
                </div>
                @endif
            </div>
            
            @if($registration->status === 'approved')
                <!-- QR Code for Entry -->
                <div class="my-8 py-6 border-t border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Entry Pass</h2>
                    
                    <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                        <!-- QR Code -->
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <!-- Replace with actual QR code generation -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=EventRegistration:{{ $registration->id }}" alt="Event QR Code" class="w-36 h-36 mx-auto" />
                            <p class="text-sm text-gray-500 mt-2 text-center">Scan at entry</p>
                        </div>
                        
                        <!-- PDF Pass Download Button -->
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400 mb-3">Download your event pass to skip the line:</p>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF Pass
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Event-day Instructions -->
                <div class="mb-8 bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg text-left">
                    <h2 class="text-lg font-medium text-blue-800 dark:text-blue-300 mb-3">Event-Day Instructions</h2>
                    
                    <div class="space-y-3 text-blue-700 dark:text-blue-300">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p><span class="font-medium">Arrival Time:</span> Please arrive between 7:00 AM - 8:30 AM for check-in</p>
                        </div>
                        
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p><span class="font-medium">Entrance Gate:</span> Please use the north entrance (Gate B) for car show participants</p>
                        </div>
                        
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p><span class="font-medium">What to Bring:</span> Your digital or printed pass, ID, and registration confirmation</p>
                        </div>
                        
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p><span class="font-medium">Important:</span> No outside food or drinks allowed. Pets must be on leash at all times.</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="text-center space-y-4">
                @if($registration->status !== 'approved')
                    <p class="text-gray-600 dark:text-gray-400 text-sm">You will receive a notification when your registration status is updated.</p>
                @endif
                
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('public.events.show', $registration->event) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        Back to Event
                    </a>
                    <a href="{{ route('event-registrations.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        View All My Registrations
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
