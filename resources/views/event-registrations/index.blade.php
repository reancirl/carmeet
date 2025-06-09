<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
            
                    @if (!$registrations->isEmpty())
                        <!-- Event Registration Cards -->
                        <div class="grid grid-cols-1 gap-6">
                            @foreach ($registrations as $registration)
                                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="p-5">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <!-- Event Info -->
                                            <div class="col-span-2">
                                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $registration->event->name ?? 'N/A' }}</h2>
                                        
                                        @if($registration->event->is_multi_day)
                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    Multi-day Event
                                                </span>
                                            </div>
                                            
                                            @foreach($registration->event->days->take(2) as $day)
                                                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1 ml-5">
                                                    <div class="flex-shrink-0 w-4 mr-1"></div><!-- Spacing to align with icon above -->
                                                    {{ \Carbon\Carbon::parse($day->date)->format('F d, Y') }}: 
                                                    {{ date('g:i A', strtotime($day->start_time)) }} - {{ date('g:i A', strtotime($day->end_time)) }}
                                                </div>
                                            @endforeach
                                            
                                            @if($registration->event->days->count() > 2)
                                                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1 ml-5 italic">
                                                    <div class="flex-shrink-0 w-4 mr-1"></div><!-- Spacing to align with icon above -->
                                                    + {{ $registration->event->days->count() - 2 }} more days...
                                                </div>
                                            @endif
                                        @else
                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $registration->event->date ? $registration->event->date->format('F d, Y') : 'N/A' }}
                                            </div>
                                            
                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $registration->event->start_time ? date('g:i A', strtotime($registration->event->start_time)) : '' }} - 
                                                {{ $registration->event->end_time ? date('g:i A', strtotime($registration->event->end_time)) : '' }}
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $registration->event->location_name ?? '' }}
                                        </div>
                                        
                                        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                            <p><span class="font-medium">Registered Car:</span> 
                                                @if($registration->carProfile)
                                                    {{ $registration->carProfile->year }} {{ $registration->carProfile->make }} {{ $registration->carProfile->model }}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                            
                                            @if($registration->crew_name)
                                                <p class="mt-1"><span class="font-medium">Crew:</span> {{ $registration->crew_name }}</p>
                                            @endif
                                            
                                            @if($registration->class)
                                                <p class="mt-1"><span class="font-medium">Class:</span> {{ $registration->class }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Status Info -->
                                    <div class="md:border-l md:border-r border-gray-200 dark:border-gray-600 md:px-6 flex flex-col justify-center">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Registration Status</p>
                                            
                                            @switch($registration->status)
                                                @case('pending')
                                                    <div class="inline-flex items-center px-4 py-2 rounded-full font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Pending Review
                                                    </div>
                                                    @break
                                                    
                                                @case('approved')
                                                    <div class="inline-flex items-center px-4 py-2 rounded-full font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Approved
                                                    </div>
                                                    @break
                                                    
                                                @case('waitlisted')
                                                    <div class="inline-flex items-center px-4 py-2 rounded-full font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        Waitlisted
                                                    </div>
                                                    @break
                                                    
                                                @case('denied')
                                                    <div class="inline-flex items-center px-4 py-2 rounded-full font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Denied
                                                    </div>
                                                    @break
                                                    
                                                @default
                                                    <div class="inline-flex items-center px-4 py-2 rounded-full font-medium bg-gray-100 text-gray-800 dark:bg-gray-800/30 dark:text-gray-500">
                                                        {{ ucfirst($registration->status) }}
                                                    </div>
                                            @endswitch
                                            
                                            <!-- Payment Status -->
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Payment Status</p>
                                                @if($registration->is_paid)
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Paid
                                                    </div>
                                                @else
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-800/30 dark:text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Unpaid
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <a href="{{ route('event-registrations.show', $registration) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </a>
                                        
                                        @if($registration->status === 'approved')
                                            <!-- Download Entry Pass -->
                                            <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Entry Pass
                                            </a>
                                            
                                            <!-- View QR Code -->
                                            <a href="{{ route('event-registrations.confirmation', $registration) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                </svg>
                                                QR Code
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <br>
                          @if (!$attendedEventIds->isEmpty())
                            <div class="grid grid-cols-1 gap-6">
                               @foreach ($attendedEventIds as $attendedEventId)
                                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="p-5">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <!-- Event Info -->
                                            <div class="col-span-2">
                                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $attendedEventId->event->name ?? 'N/A' }}</h2>
                                        
                                        @if($attendedEventId->event->is_multi_day)
                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    Multi-day Event
                                                </span>
                                            </div>
                                            
                                            @foreach($attendedEventId->event->days->take(2) as $day)
                                                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1 ml-5">
                                                    <div class="flex-shrink-0 w-4 mr-1"></div><!-- Spacing to align with icon above -->
                                                    {{ \Carbon\Carbon::parse($day->date)->format('F d, Y') }}: 
                                                    {{ date('g:i A', strtotime($day->start_time)) }} - {{ date('g:i A', strtotime($day->end_time)) }}
                                                </div>
                                            @endforeach
                                            
                                            @if($attendedEventId->event->days->count() > 2)
                                                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1 ml-5 italic">
                                                    <div class="flex-shrink-0 w-4 mr-1"></div><!-- Spacing to align with icon above -->
                                                    + {{ $attendedEventId->event->days->count() - 2 }} more days...
                                                </div>
                                            @endif
                                        @else
                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $attendedEventId->event->date ? $attendedEventId->event->date->format('F d, Y') : 'N/A' }}
                                            </div>
                                            
                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $attendedEventId->event->start_time ? date('g:i A', strtotime($attendedEventId->event->start_time)) : '' }} - 
                                                {{ $attendedEventId->event->end_time ? date('g:i A', strtotime($attendedEventId->event->end_time)) : '' }}
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $attendedEventId->event->location_name ?? '' }}
                                        </div>
                                    </div>
                                    
                                    <!-- Status Info -->
                                    <div class="md:border-l md:border-r border-gray-200 dark:border-gray-600 md:px-6 flex flex-col justify-center">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Registration Status</p>
                                            <h4>Attendee</h4>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <a href="{{ route('event-registrations.attend.show', $attendedEventId->event->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                            </div>
                        @endif
                        <div class="mt-4">
                            {{ $registrations->links() }}
                        </div>
                    @else
                            @if (!$attendedEventIds->isEmpty())
                                <div class="grid grid-cols-1 gap-6">
                                @foreach ($attendedEventIds as $attendedEventId)
                                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-600">
                                                <div class="p-5">
                                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                                        <!-- Event Info -->
                                                        <div class="col-span-2">
                                                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $attendedEventId->event->name ?? 'N/A' }}</h2>
                                                    
                                                    @if($attendedEventId->event->is_multi_day)
                                                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                Multi-day Event
                                                            </span>
                                                        </div>
                                                        
                                                        @foreach($attendedEventId->event->days->take(2) as $day)
                                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1 ml-5">
                                                                <div class="flex-shrink-0 w-4 mr-1"></div><!-- Spacing to align with icon above -->
                                                                {{ \Carbon\Carbon::parse($day->date)->format('F d, Y') }}: 
                                                                {{ date('g:i A', strtotime($day->start_time)) }} - {{ date('g:i A', strtotime($day->end_time)) }}
                                                            </div>
                                                        @endforeach
                                                        
                                                        @if($attendedEventId->event->days->count() > 2)
                                                            <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1 ml-5 italic">
                                                                <div class="flex-shrink-0 w-4 mr-1"></div><!-- Spacing to align with icon above -->
                                                                + {{ $attendedEventId->event->days->count() - 2 }} more days...
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            {{ $attendedEventId->event->date ? $attendedEventId->event->date->format('F d, Y') : 'N/A' }}
                                                        </div>
                                                        
                                                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ $attendedEventId->event->start_time ? date('g:i A', strtotime($attendedEventId->event->start_time)) : '' }} - 
                                                            {{ $attendedEventId->event->end_time ? date('g:i A', strtotime($attendedEventId->event->end_time)) : '' }}
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        {{ $attendedEventId->event->location_name ?? '' }}
                                                    </div>
                                                </div>
                                                
                                                <!-- Status Info -->
                                                <div class="md:border-l md:border-r border-gray-200 dark:border-gray-600 md:px-6 flex flex-col justify-center">
                                                    <div class="text-center">
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Registration Status</p>
                                                        <h4>Attendee</h4>
                                                    </div>
                                                </div>
                                                
                                                <!-- Actions -->
                                                <div class="flex flex-col items-center justify-center space-y-3">
                                                    <a href="{{ route('event-registrations.attend.show', $attendedEventId->event->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't registered for any events yet.</p>
                                <a href="{{ route('public.events.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Browse Events') }}
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>