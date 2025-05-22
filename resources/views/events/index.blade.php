<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create New Event') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Date & Time') }}</th>
                                    @if(auth()->user()->role == 'admin')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Host') }}</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Attendees') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($events as $event)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ date('m/d/Y (D), ', strtotime($event->date)) }} {{ date('g:i A', strtotime($event->start_time)) }} - {{ date('g:i A', strtotime($event->end_time)) }}</td>
                                    @if(auth()->user()->role == 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $event->host->name }}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->attendees->count() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-900 mr-2">{{ __('View') }}</a>
                                        <a href="{{ route('events.edit', $event) }}" class="text-green-600 hover:text-green-900 mr-2">{{ __('Edit') }}</a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
