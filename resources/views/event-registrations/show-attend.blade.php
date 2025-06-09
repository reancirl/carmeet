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
                        @if($registration)
                            <div class="space-y-2">
                                <p><span class="text-gray-500">Event Name:</span> {{ $registration->name }}</p>
                                @if($registration->is_multi_day)
                                    <p>
                                        <span class="text-gray-500">Event Type:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Multi-day Event
                                        </span>
                                    </p>
                                    <div class="pl-4 border-l-2 border-purple-200 mt-2 mb-2">
                                        @foreach($registration->days as $day)
                                            <p class="mb-1">
                                                <span class="text-gray-500">Day {{ $loop->iteration }}:</span> 
                                                {{ \Carbon\Carbon::parse($day->date)->format('F d, Y') }}, 
                                                {{ date('g:i A', strtotime($day->start_time)) }} - {{ date('g:i A', strtotime($day->end_time)) }}
                                            </p>
                                        @endforeach
                                    </div>
                                @else
                                    <p><span class="text-gray-500">Date:</span> {{ $registration->date ? $registration->date->format('F d, Y') : 'N/A' }}</p>
                                    <p><span class="text-gray-500">Time:</span> 
                                        {{ $registration->start_time ? date('g:i A', strtotime($registration->start_time)) : '' }} - 
                                        {{ $registration->end_time ? date('g:i A', strtotime($registration->end_time)) : '' }}
                                    </p>
                                @endif
                                <p><span class="text-gray-500">Location:</span> 
                                    @if($registration->location_name)
                                        {{ $registration->location_name }}, 
                                    @endif
                                    @if($registration->street || $registration->city || $registration->state || $registration->zip_code)
                                        {{ $registration->street }}, {{ $registration->city }}, {{ $registration->state }} {{ $registration->zip_code }}
                                    @endif
                                </p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('public.events.show', $registration) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" target="_blank">
                                    View Event Details
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500">Event information is not available.</p>
                        @endif
                    </div>
                    
                    <!-- Registration Status -->
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