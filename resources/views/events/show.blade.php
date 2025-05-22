<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $event->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('Date') }}</p>
                                        <p class="font-medium">{{ $event->date->format('m/d/Y (D)') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('Time') }}</p>
                                        <p class="font-medium">
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('g:ia') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('g:ia') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('Location') }}</p>
                                        <p class="font-medium">{{ $event->location }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('Zip Code') }}</p>
                                        <p class="font-medium">{{ $event->zip_code }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h2 class="text-xl font-semibold mb-2">{{ __('Description') }}</h2>
                                <p class="text-gray-700 dark:text-gray-400">{{ $event->description }}</p>
                            </div>

                            <div>
                                <h2 class="text-xl font-semibold mb-2">{{ __('Host') }}</h2>
                                <p class="font-medium">{{ $event->host->name }}</p>
                            </div>

                            <div>
                                <h2 class="text-xl font-semibold mb-2">
                                    {{ __('Attendees') }} ({{ $event->attendees->count() }})
                                </h2>
                                <div class="space-y-2">
                                    @foreach($event->attendees as $attendee)
                                        <div class="flex items-center">
                                            <p class="flex-1 font-medium">{{ $attendee->name }}</p>
                                            @if($event->host_id === auth()->id())
                                                <form
                                                    action="{{ route('event.attendees.detach', ['event' => $event, 'attendee' => $attendee]) }}"
                                                    method="POST"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-500"
                                                        onclick="return confirm('{{ __('Remove this attendee?') }}')"
                                                    >
                                                        {{ __('Remove') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if($event->host_id === auth()->id())
                                <div class="mt-6 flex justify-end space-x-3">
                                    <a
                                        href="{{ route('events.edit', $event) }}"
                                        class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
                                    >
                                        {{ __('Edit Event') }}
                                    </a>
                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="bg-red-600 dark:bg-red-500 hover:bg-red-700 dark:hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                                            onclick="return confirm('{{ __('Delete this event?') }}')"
                                        >
                                            {{ __('Delete Event') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
