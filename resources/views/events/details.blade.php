<x-public-layout :title="$event->name">
    <div class="flex-grow w-full lg:max-w-10xl mx-auto px-6 lg:px-8 py-8 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Go Back') }}
                </a>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/3 lg:w-2/5">
                                @if ($event->image_url)
                                    <img src="{{ $event->image_url }}" alt="{{ $event->name }}"
                                        class="w-full h-auto object-cover rounded-lg shadow-md">
                                @else
                                    <div
                                        class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-400">No image available</span>
                                    </div>
                                @endif
                            </div>

                            <div class="md:flex-1">
                                {{-- Date at top --}}
                                <div class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">
                                    @if ($event->is_multi_day)
                                        <div class="flex items-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 mr-2">
                                                {{ __('Multi-day Event') }}
                                            </span>
                                        </div>
                                        <div class="space-y-1 mt-1">
                                            @foreach ($event->days as $day)
                                                <p>
                                                    {{ \Carbon\Carbon::parse($day->date)->format('d M Y') }} •
                                                    {{ \Carbon\Carbon::parse($day->start_time)->format('g:ia') }} -
                                                    {{ \Carbon\Carbon::parse($day->end_time)->format('g:ia') }}
                                                </p>
                                            @endforeach
                                        </div>
                                    @else
                                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} •
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:ia') }} -
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('g:ia') }}
                                    @endif
                                </div>

                                {{-- Event Title --}}
                                <h2 class="text-3xl font-bold mb-3">{{ $event->name }}</h2>

                                <div class="flex items-center gap-3 mb-3">
                                    @if (isset($event->organizer) && $event->organizer)
                                        @if ($event->organizer->image_url)
                                            <img src="{{ url('storage/' . $event->organizer->image_url) }}"
                                                alt="{{ $event->organizer->name }}"
                                                class="w-10 h-10 object-cover rounded-full">
                                        @else
                                            <div
                                                class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-full flex items-center justify-center">
                                                <span
                                                    class="text-indigo-700 dark:text-indigo-300 font-semibold">{{ isset($event->organizer->name) ? substr($event->organizer->name, 0, 1) : '?' }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">Organized by</p>
                                            <p class="font-medium">{{ $event->organizer->name }}</p>
                                        </div>
                                    @else
                                        <div
                                            class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-700 dark:text-indigo-300 font-semibold">?</span>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">organizer information
                                            </p>
                                            <p class="font-medium">Not available</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Location --}}
                                <div class="flex items-start mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div>
                                        <p class="font-medium">{{ $event->location_name }}</p>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $event->street }}</p>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $event->city }},
                                            {{ $event->state }} {{ $event->zip_code }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <!-- Drivers Badge -->
                                    <div class="flex items-center space-x-2 px-3 py-1.5 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-lg shadow-sm hover:shadow-md transition-shadow"
                                        aria-label="{{ $event->registrations->count() }} drivers">
                                        <span class="text-sm font-medium">
                                            Drivers ({{ $event->registrations->count() }})
                                        </span>
                                    </div>

                                    <div class="flex items-center space-x-2 px-3 py-1.5 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-lg shadow-sm hover:shadow-md transition-shadow"
                                        aria-label="{{ $event->attendees->count() }} attendees">
                                        <span class="text-sm font-medium">
                                            Attendees ({{ $event->attendees->count() }})
                                        </span>
                                    </div>
                                </div>

                                {{-- Register Button --}}
                                @auth
                                    @php
                                        // Check if user has any car profiles registered for this event
                                        $userCarProfileIds = Auth::user()->carProfiles()->pluck('id');
                                        $hasRegistered = App\Models\CarEventRegistration::whereIn(
                                            'car_profile_id',
                                            $userCarProfileIds,
                                        )
                                            ->where('event_id', $event->id)
                                            ->exists();
                                        $hasRegisteredattendee = App\Models\EventAttendee::where(
                                            'attendee_id',
                                            Auth::user()->id,
                                        )
                                            ->where('event_id', $event->id)
                                            ->exists();
                                    @endphp

                                    @if (!$hasRegistered && $event->organizer_id !== Auth::user()->id)
                                        @if (Auth::user()->role == 'driver')
                                            @if (!$hasRegisteredattendee)
                                                <div class="mt-4">
                                                    <a href="{{ route('event-registrations.create', $event) }}"
                                                        class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                        </svg>
                                                        Register a Car
                                                    </a>
                                                </div>
                                                <div class="mt-4">
                                                    <button type="button"
                                                        class="js-rsvp inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                        data-event-slug="{{ $event->slug }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                        </svg>
                                                        RSVP to Event
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-4">
                                                    <a href="{{ route('event-registrations.index') }}"
                                                        class="inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        You’ve already registered your car for this event.
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            @if (!$hasRegisteredattendee)
                                                <div class="mt-4">
                                                    <button type="button"
                                                        class="js-rsvp inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                        data-event-slug="{{ $event->slug }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                        </svg>
                                                        RSVP to Event
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-4">
                                                    <a href="{{ route('event-registrations.index') }}"
                                                        class="inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        You’ve already RSVP’d to this event.
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @elseif ($event->organizer_id !== Auth::user()->id)
                                        <div class="mt-4">
                                            <a href="{{ route('event-registrations.index') }}"
                                                class="inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Already Registered - View Registration
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div class="mt-4">
                                        <a href="{{ route('login') }}"
                                            class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                            Log in to Register a Car or RSVP as an Attendee
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                    {{-- Event Description --}}
                    @if ($event->description)
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl font-semibold mb-4">{{ __('Event Description') }}</h3>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    @endif

                    {{-- Event Files Section --}}
                    @php
                        // Get files based on user authentication and visibility
                        $publicFiles = $event->files->where('visibility', 'public');
                        $approvedOnlyFiles = $event->files->where('visibility', 'approved_only');
                        $showApprovedOnly =
                            auth()->check() &&
                            (auth()->user()->id === $event->organizer_id ||
                                App\Models\CarEventRegistration::whereIn(
                                    'car_profile_id',
                                    auth()->user()->carProfiles()->pluck('id'),
                                )
                                    ->where('event_id', $event->id)
                                    ->where('status', 'approved')
                                    ->exists());

                        // Check if we have any files to show
                        $hasPublicFiles = $publicFiles->isNotEmpty();
                        $hasApprovedFiles = $showApprovedOnly && $approvedOnlyFiles->isNotEmpty();
                    @endphp

                    @if ($hasPublicFiles || $hasApprovedFiles)
                        <div class="mt-12 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl font-semibold mb-6">{{ __('Event Files') }}</h3>

                            @if ($hasPublicFiles)
                                @if ($hasPublicFiles && $hasApprovedFiles)
                                    <h4 class="text-md font-medium mb-3 text-gray-700 dark:text-gray-300">
                                        {{ __('Public Files') }}</h4>
                                @endif
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                    @foreach ($publicFiles as $file)
                                        @include('events.components.file-card', ['file' => $file])
                                    @endforeach
                                </div>
                            @endif

                            @if ($hasApprovedFiles)
                                <div class="mt-6">
                                    <div class="flex items-center mb-3">
                                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-300">
                                            {{ __('Approved Participants Only') }}
                                        </h4>
                                        <span
                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <i class="fas fa-lock mr-1"></i>
                                            {{ __('Restricted Access') }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach ($approvedOnlyFiles as $file)
                                            @include('events.components.file-card', [
                                                'file' => $file,
                                                'isApprovedOnly' => true,
                                            ])
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            const rsvpButtons = document.querySelectorAll('.js-rsvp');

            rsvpButtons.forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();

                    // Native confirmation
                    if (!confirm('Are you sure you want to RSVP to this event?')) {
                        return;
                    }

                    // Redirect via GET
                    const eventSlug = button.dataset.eventSlug;
                    window.location.href = `/events/attendee/${eventSlug}/register`;
                });
            });
        });
    </script>

</x-public-layout>
