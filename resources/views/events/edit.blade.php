<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Event Name') }}</label>
                                <input type="text" name="name" id="name" value="{{ $event->name }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Date') }}</label>
                                <input type="date" name="date" id="date" value="{{ $event->date ? date('Y-m-d', strtotime($event->date)) : '' }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                            </div>

                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Time') }}</label>
                                <input type="time" name="time" id="time" value="{{ $event->time }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Description') }}</label>
                                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>{{ $event->description }}</textarea>
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Location') }}</label>
                                <input type="text" name="location" id="location" value="{{ $event->location }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                            </div>

                            <div>
                                <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Zip Code') }}</label>
                                <input type="text" name="zip_code" id="zip_code" value="{{ $event->zip_code }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required pattern="[0-9]{4,6}">
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Event Image') }}</label>
                                @if($event->image)
                                    <div class="mt-2">
                                        <img src="{{ $event->image_url }}" alt="{{ $event->name }}" 
                                             class="w-32 h-32 object-cover rounded-lg">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/*" 
                                       class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Update Event') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
