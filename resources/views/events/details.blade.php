<x-public-layout :title="$event->name">
    <div class="flex-grow w-full lg:max-w-10xl mx-auto px-6 lg:px-8 py-8 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/3 lg:w-2/5">
                                @if($event->image_url)
                                    <img
                                        src="{{ $event->image_url }}"
                                        alt="{{ $event->name }}"
                                        class="w-full h-auto object-cover rounded-lg shadow-md"
                                    >
                                @else
                                    <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-400">No image available</span>
                                    </div>
                                @endif
                            </div>
                                    
                            {{-- Event Details (Right) --}}
                            <div class="md:flex-1">
                                {{-- Date at top --}}
                                <div class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">
                                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ \Carbon\Carbon::parse($event->start_time)->format('g:ia') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('g:ia') }}
                                </div>
                                
                                {{-- Event Title --}}
                                <h2 class="text-3xl font-bold mb-3">{{ $event->name }}</h2>
                                
                                {{-- Host/Organizer --}}
                                <div class="flex items-center gap-3 mb-3">
                                    @if(isset($event->host) && $event->host)
                                        @if($event->host->image_url)
                                            <img src="{{ url('storage/' . $event->host->image_url) }}" alt="{{ $event->host->name }}" class="w-10 h-10 object-cover rounded-full">
                                        @else
                                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-full flex items-center justify-center">
                                                <span class="text-indigo-700 dark:text-indigo-300 font-semibold">{{ isset($event->host->name) ? substr($event->host->name, 0, 1) : '?' }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">Hosted by</p>
                                            <p class="font-medium">{{ $event->host->name }}</p>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-700 dark:text-indigo-300 font-semibold">?</span>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">Host information</p>
                                            <p class="font-medium">Not available</p>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Location --}}
                                <div class="flex items-start mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div>
                                        <p class="font-medium">{{ $event->location_name }}</p>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $event->street }}</p>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $event->city }}, {{ $event->state }} {{ $event->zip_code }}</p>
                                    </div>
                                </div>
                                
                                {{-- Register Button --}}
                                @auth
                                    <div class="mt-4">
                                        <a href="{{ route('event-registrations.create', $event) }}" class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                            Register for this Event
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                            Login to Register
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                            
                        {{-- Description --}}
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold mb-3">Description</h3>
                            <p class="text-gray-700 dark:text-gray-400">{{ $event->description }}</p>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a
                                href="{{ route('public.events.index') }}"
                                class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 font-medium"
                            >
                                &larr; Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
