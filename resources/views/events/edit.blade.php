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
                            {{-- Event Name --}}
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Event Name') }}
                                </label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $event->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('name') border-red-500 @enderror"
                                    required>
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div>
                                <label for="slug"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('URL Slug') }} <span class="text-xs text-gray-500">(auto-generated, but can be
                                        customized)</span>
                                </label>
                                <input type="text" name="slug" id="slug"
                                    value="{{ old('slug', $event->slug) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('slug') border-red-500 @enderror">
                                @error('slug')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Multi-day Event Checkbox --}}
                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_multi_day" id="is_multi_day" value="1"
                                        {{ old('is_multi_day', $event->is_multi_day) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="is_multi_day"
                                        class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('This is a multiple day event') }}
                                    </label>
                                </div>
                                @error('is_multi_day')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Single Day Event Fields --}}
                            <div id="single-day-fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                                {{-- Date --}}
                                <div>
                                    <label for="date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Date') }}
                                    </label>
                                    <input type="date" name="date" id="date"
                                        value="{{ old('date', $event->date?->format('Y-m-d')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                            @error('date') border-red-500 @enderror">
                                    @error('date')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Start Time --}}
                                <div>
                                    <label for="start_time"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Start Time') }}
                                    </label>
                                    <input type="time" name="start_time" id="start_time"
                                        value="{{ old('start_time', $event->start_time?->format('H:i')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                            @error('start_time') border-red-500 @enderror">
                                    @error('start_time')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- End Time --}}
                                <div>
                                    <label for="end_time"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('End Time') }}
                                    </label>
                                    <input type="time" name="end_time" id="end_time"
                                        value="{{ old('end_time', $event->end_time?->format('H:i')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                            @error('end_time') border-red-500 @enderror">
                                    @error('end_time')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Multi-day Event Fields --}}
                            <div id="multi-day-fields" class="md:col-span-2" style="display: none;">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Event Days</h3>
                                    <button type="button" id="add-day-btn"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add Day
                                    </button>
                                </div>
                                <div id="event-days-container" class="space-y-4">
                                    <!-- Event days will be added here dynamically -->
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Description') }}
                                </label>
                                <textarea name="description" id="description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('description') border-red-500 @enderror"
                                    required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Location Name --}}
                            <div>
                                <label for="location_name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Location Name') }}
                                </label>
                                <input type="text" name="location_name" id="location_name"
                                    value="{{ old('location_name', $event->location_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('location_name') border-red-500 @enderror"
                                    required>
                                @error('location_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Street --}}
                            <div>
                                <label for="street"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Street') }}
                                </label>
                                <input type="text" name="street" id="street"
                                    value="{{ old('street', $event->street) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('street') border-red-500 @enderror"
                                    required>
                                @error('street')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div>
                                <label for="city"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('City') }}
                                </label>
                                <input type="text" name="city" id="city"
                                    value="{{ old('city', $event->city) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('city') border-red-500 @enderror"
                                    required>
                                @error('city')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- State --}}
                            <div>
                                <label for="state"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('State') }}
                                </label>
                                <select name="state" id="state"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('state') border-red-500 @enderror"
                                    required>
                                    @foreach (config('states') as $abbr => $stateName)
                                        <option value="{{ $abbr }}"
                                            {{ old('state', $event->state) == $abbr ? 'selected' : '' }}>
                                            {{ $stateName }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Zip Code --}}
                            <div>
                                <label for="zip_code"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Zip Code') }}
                                </label>
                                <input type="text" name="zip_code" id="zip_code"
                                    value="{{ old('zip_code', $event->zip_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('zip_code') border-red-500 @enderror"
                                    required>
                                @error('zip_code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Featured? --}}
                            @php
                                // Determine the current “featured” state:
                                $featured = old('is_featured', isset($event) ? $event->is_featured : false);
                            @endphp

                            {{-- Only show to admins --}}
                            @if (auth()->user()->role === 'admin')
                                <div x-data="{ featured: {{ $featured ? 'true' : 'false' }} }" class="flex items-center space-x-3">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Feature this event?') }}
                                    </span>

                                    <!-- Toggle -->
                                    <button type="button" @click="featured = !featured"
                                        :class="featured ? 'bg-indigo-600' : 'bg-gray-200'"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                                        <span :class="featured ? 'translate-x-6' : 'translate-x-1'"
                                            class="inline-block h-4 w-4 transform bg-white rounded-full transition-transform"></span>
                                    </button>

                                    <!-- Hidden input to carry the value -->
                                    <input type="hidden" name="is_featured" :value="featured ? 1 : 0">
                                </div>
                                @error('is_featured')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            @endif

                            {{-- Image --}}
                            <div class="md:col-span-2">
                                <label for="image"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Event Image') }} <span class="text-xs text-gray-500">(Max 5MB)</span>
                                </label>
                                <div id="image-preview-container" class="mt-2">
                                    @if ($event->image_url)
                                        <img src="{{ $event->image_url }}" alt="{{ $event->name }}"
                                            class="w-72 h-72 object-cover rounded-lg" id="current-image">
                                    @endif
                                    <img id="image-preview" class="w-72 h-72 object-cover rounded-lg hidden"
                                        alt="New Preview">
                                </div>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="mt-2 block w-full text-sm text-gray-500
                                           file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                                           file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                           @error('image') border-red-500 @enderror">
                                @error('image')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Update Event') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate slug from event name
        document.getElementById('name').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            // Only update slug if it hasn't been manually modified
            const currentSlug = slugify(this.value);
            if (!slugInput.dataset.manuallyEdited) {
                slugInput.value = currentSlug;
            }
        });

        // Track manual slug edits
        document.getElementById('slug').addEventListener('input', function() {
            const nameInput = document.getElementById('name');
            const currentSlug = slugify(nameInput.value);
            if (this.value !== currentSlug) {
                this.dataset.manuallyEdited = 'true';
            } else {
                delete this.dataset.manuallyEdited;
            }
        });

        // Helper function to create URL-friendly slugs
        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        }

        // Event Day Template Function
        function createEventDayTemplate(index, data = null) {
            const dayId = data && data.id ? data.id : '';
            const date = data ? data.date : '';
            const startTime = data ? data.start_time : '';
            const endTime = data ? data.end_time : '';

            return `
                <div class="event-day-item p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-md font-medium">Day ${index + 1}</h4>
                        <button type="button" class="remove-day text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    
                    <input type="hidden" name="event_days[${index}][id]" value="${dayId}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                            <input
                                type="date"
                                name="event_days[${index}][date]"
                                value="${date}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                            <input
                                type="time"
                                name="event_days[${index}][start_time]"
                                value="${startTime}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                            <input
                                type="time"
                                name="event_days[${index}][end_time]"
                                value="${endTime}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                required
                            >
                        </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Initialize multi-day event functionality
        document.addEventListener('DOMContentLoaded', function() {
            const isMultiDayCheckbox = document.getElementById('is_multi_day');
            const singleDayFields = document.getElementById('single-day-fields');
            const multiDayFields = document.getElementById('multi-day-fields');
            const addDayBtn = document.getElementById('add-day-btn');
            const eventDaysContainer = document.getElementById('event-days-container');

            // Load existing event days if this is a multi-day event
            @if ($event->is_multi_day && $event->days->count() > 0)
                const existingDays = [
                    @foreach ($event->days as $index => $day)
                        {
                            id: {{ $day->id }},
                            date: '{{ $day->date->format('Y-m-d') }}',
                            start_time: '{{ $day->start_time->format('H:i') }}',
                            end_time: '{{ $day->end_time->format('H:i') }}'
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ];

                existingDays.forEach((day, index) => {
                    eventDaysContainer.insertAdjacentHTML('beforeend', createEventDayTemplate(index, day));
                });
            @endif

            // Set initial state based on checkbox
            function toggleDayFields() {
                if (isMultiDayCheckbox.checked) {
                    singleDayFields.style.display = 'none';
                    multiDayFields.style.display = 'block';

                    // If no days exist, add one by default
                    if (eventDaysContainer.children.length === 0) {
                        eventDaysContainer.insertAdjacentHTML('beforeend', createEventDayTemplate(0));
                    }
                } else {
                    singleDayFields.style.display = 'grid';
                    multiDayFields.style.display = 'none';
                }
            }

            // Initialize state
            toggleDayFields();

            // Toggle on checkbox change
            isMultiDayCheckbox.addEventListener('change', toggleDayFields);

            // Add new day
            addDayBtn.addEventListener('click', function() {
                const index = eventDaysContainer.children.length;
                eventDaysContainer.insertAdjacentHTML('beforeend', createEventDayTemplate(index));
            });

            // Remove day (event delegation)
            eventDaysContainer.addEventListener('click', function(event) {
                if (event.target.closest('.remove-day')) {
                    const dayItem = event.target.closest('.event-day-item');
                    dayItem.remove();

                    // If all days are removed, add one back
                    if (eventDaysContainer.children.length === 0) {
                        eventDaysContainer.insertAdjacentHTML('beforeend', createEventDayTemplate(0));
                    }

                    // Renumber the days
                    Array.from(eventDaysContainer.children).forEach((item, index) => {
                        const heading = item.querySelector('h4');
                        heading.textContent = `Day ${index + 1}`;

                        // Update indices in input names
                        const inputs = item.querySelectorAll('input');
                        inputs.forEach(input => {
                            if (input.name.includes('[id]')) {
                                input.name = `event_days[${index}][id]`;
                            } else if (input.name.includes('[date]')) {
                                input.name = `event_days[${index}][date]`;
                            } else if (input.name.includes('[start_time]')) {
                                input.name = `event_days[${index}][start_time]`;
                            } else if (input.name.includes('[end_time]')) {
                                input.name = `event_days[${index}][end_time]`;
                            }
                        });
                    });
                }
            });

            // Image preview functionality
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
        });
    </script>
</x-app-layout>
