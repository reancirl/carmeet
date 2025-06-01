<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Global Errors --}}
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Event Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Event Name') }}
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $event->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('name') border-red-500 @enderror"
                                    required
                                >
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Date --}}
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Date') }}
                                </label>
                                <input
                                    type="date"
                                    name="date"
                                    id="date"
                                    value="{{ old('date', $event->date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('date') border-red-500 @enderror"
                                    required
                                >
                                @error('date')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Start Time --}}
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Start Time') }}
                                </label>
                                <input
                                    type="time"
                                    name="start_time"
                                    id="start_time"
                                    value="{{ old('start_time', $event->start_time?->format('H:i')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('start_time') border-red-500 @enderror"
                                    required
                                >
                                @error('start_time')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- End Time --}}
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('End Time') }}
                                </label>
                                <input
                                    type="time"
                                    name="end_time"
                                    id="end_time"
                                    value="{{ old('end_time', $event->end_time?->format('H:i')) }}"

                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('end_time') border-red-500 @enderror"
                                    required
                                >
                                @error('end_time')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Description') }}
                                </label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('description') border-red-500 @enderror"
                                    required
                                >{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Location Name --}}
                            <div>
                                <label for="location_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Location Name') }}
                                </label>
                                <input
                                    type="text"
                                    name="location_name"
                                    id="location_name"
                                    value="{{ old('location_name', $event->location_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('location_name') border-red-500 @enderror"
                                    required
                                >
                                @error('location_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Street --}}
                            <div>
                                <label for="street" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Street') }}
                                </label>
                                <input
                                    type="text"
                                    name="street"
                                    id="street"
                                    value="{{ old('street', $event->street) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('street') border-red-500 @enderror"
                                    required
                                >
                                @error('street')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('City') }}
                                </label>
                                <input
                                    type="text"
                                    name="city"
                                    id="city"
                                    value="{{ old('city', $event->city) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('city') border-red-500 @enderror"
                                    required
                                >
                                @error('city')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- State --}}
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('State') }}
                                </label>
                                <input
                                    type="text"
                                    name="state"
                                    id="state"
                                    value="{{ old('state', $event->state) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('state') border-red-500 @enderror"
                                    required
                                >
                                @error('state')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Zip Code --}}
                            <div>
                                <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Zip Code') }}
                                </label>
                                <input
                                    type="text"
                                    name="zip_code"
                                    id="zip_code"
                                    value="{{ old('zip_code', $event->zip_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('zip_code') border-red-500 @enderror"
                                    required
                                >
                                @error('zip_code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Image --}}
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Event Image') }} <span class="text-xs text-gray-500">(Max 5MB)</span>
                                </label>
                                <div id="image-preview-container" class="mt-2">
                                    @if($event->image_url)
                                        <img
                                            src="{{ $event->image_url }}"
                                            alt="{{ $event->name }}"
                                            class="w-72 h-72 object-cover rounded-lg"
                                            id="current-image"
                                        >
                                    @endif
                                    <img
                                        id="image-preview"
                                        class="w-72 h-72 object-cover rounded-lg hidden"
                                        alt="New Preview"
                                    >
                                </div>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    accept="image/*"
                                    class="mt-2 block w-full text-sm text-gray-500
                                           file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                                           file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                           @error('image') border-red-500 @enderror"
                                >
                                @error('image')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                {{ __('Update Event') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    const current = document.getElementById('current-image');
                    if (current) current.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
