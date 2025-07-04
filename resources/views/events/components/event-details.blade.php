@props(['event'])

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        {{-- Image and Details Container --}}
        <div class="flex flex-col md:flex-row gap-6">
            {{-- Image Preview on Left --}}
            @if($event->image_url)
                <div class="md:w-1/3">
                    <img
                        src="{{ $event->image_url }}"
                        alt="{{ $event->name }}"
                        class="w-full h-auto object-cover rounded-lg"
                    >
                </div>
            @endif

            {{-- Details on Right --}}
            <div class="md:flex-1 space-y-6">
                <div>
                    <h2 class="text-xl font-semibold mb-2">{{ __('Event Details') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">{{ __('Date & Time') }}</p>
                            @if($event->is_multi_day)
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        {{ __('Multi-day Event') }}
                                    </span>
                                </div>
                                <div class="space-y-1 mt-2">
                                    @foreach($event->days as $day)
                                        <p class="font-medium">
                                            {{ $day->date->format('m/d/Y (D)') }}
                                        </p>
                                    @endforeach
                                </div>
                            @else
                                <p class="font-medium">{{ $event->date->format('m/d/Y (D)') }}</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:ia') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('g:ia') }}
                                </p>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">{{ __('Location') }}</p>
                            <p class="font-medium">
                                {{ $event->location_name }}<br>
                                {{ $event->street }}<br>
                                {{ $event->city }}, {{ $event->state }} {{ $event->zip_code }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($event->description)
                    <div>
                        <h2 class="text-xl font-semibold mb-2">{{ __('Description') }}</h2>
                        <p class="whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                @endif

                <div>
                    <h2 class="text-xl font-semibold mb-2">{{ __('Organizer') }}</h2>
                    <p class="font-medium">{{ $event->organizer->name }}</p>
                </div>
                
                <div>
                    <h2 class="text-xl font-semibold mb-2">{{ __('Car Registratrants') }}</h2>
                    <p class="font-medium">{{ $event->registrations->count() }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold mb-2">{{ __('Attendees') }}</h2>
                    <p class="font-medium">{{ $event->attendees->count() }}</p>
                </div>

                {{-- event organizer and admin --}}
                @if(auth()->user()->is($event->organizer) || auth()->user()->role === 'admin')
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('events.edit', $event->slug) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                            {{ __('Edit') }}
                        </a>

                        <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
