<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Event') }}
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
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                    value="{{ old('name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('name') border-red-500 @enderror"
                                    required
                                >
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('URL Slug') }} <span class="text-xs text-gray-500">(auto-generated, but can be customized)</span>
                                </label>
                                <input
                                    type="text"
                                    name="slug"
                                    id="slug"
                                    value="{{ old('slug') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('slug') border-red-500 @enderror"
                                >
                                @error('slug')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Multi-day Event Checkbox --}}
                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_multi_day"
                                        id="is_multi_day"
                                        value="1"
                                        {{ old('is_multi_day') ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                    <label for="is_multi_day" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
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
                                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Date') }}
                                    </label>
                                    <input
                                        type="date"
                                        name="date"
                                        id="date"
                                        value="{{ old('date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                            @error('date') border-red-500 @enderror"
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
                                        value="{{ old('start_time') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                            @error('start_time') border-red-500 @enderror"
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
                                        value="{{ old('end_time') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                            @error('end_time') border-red-500 @enderror"
                                    >
                                    @error('end_time')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Multi-day Event Fields --}}
                            <div id="multi-day-fields" class="md:col-span-2" style="display: none;">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Event Days</h3>
                                    <button
                                        type="button"
                                        id="add-day-btn"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Add Day
                                    </button>
                                </div>
                                <div id="event-days-container" class="space-y-4">
                                    <!-- Event days will be added here -->
                                </div>
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
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Location --}}

                            <div>
                                <label for="location_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Location Name') }}
                                </label>
                                <input
                                    type="text"
                                    name="location_name"
                                    id="location_name"
                                    value="{{ old('location_name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('location_name') border-red-500 @enderror"
                                    required
                                >
                                @error('location_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="street" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Street') }}
                                </label>
                                <input
                                    type="text"
                                    name="street"
                                    id="street"
                                    value="{{ old('street') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('street') border-red-500 @enderror"
                                    required
                                >
                                @error('street')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('City') }}
                                </label>
                                <input
                                    type="text"
                                    name="city"
                                    id="city"
                                    value="{{ old('city') }}"
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
                                <select
                                    name="state"
                                    id="state"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('state') border-red-500 @enderror"
                                    required
                                >
                                    @foreach(config('states') as $abbr => $stateName)
                                        <option value="{{ $abbr }}" {{ old('state') == $abbr ? 'selected' : '' }}>{{ $stateName }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Zip Code') }}
                                </label>
                                <input
                                    type="text"
                                    name="zip_code"
                                    id="zip_code"
                                    value="{{ old('zip_code') }}"
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
                                    {{ __('Event Image') }}  <span class="text-xs text-gray-500"> (- JPG, JPEG, PNG. Max size: 5MB.)</span>
                                </label>
                                <div id="image-preview-container" class="mt-2">
                                    <img
                                        id="image-preview"
                                        class="w-72 h-72 object-cover rounded-lg hidden"
                                        alt="Preview"
                                    >
                                </div>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500
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
                                class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
                            >
                                {{ __('Create Event') }}
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
                .replace(/\s+/g, '-')        // Replace spaces with -
                .replace(/[^\w\-]+/g, '')   // Remove all non-word chars
                .replace(/\-\-+/g, '-')      // Replace multiple - with single -
                .replace(/^-+/, '')          // Trim - from start of text
                .replace(/-+$/, '');         // Trim - from end of text
        }

        // Handle form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            // Only validate visible fields
            const hiddenFields = document.querySelectorAll('#multi-day-fields [required]');
            if (!document.getElementById('is_multi_day').checked) {
                // If not multi-day, remove required from all multi-day fields
                hiddenFields.forEach(field => field.removeAttribute('required'));
            }
            // The form will now validate only the visible required fields
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
                }
                reader.readAsDataURL(file);
            }
        });

        // Multi-day event functionality
        document.addEventListener('DOMContentLoaded', function() {
            const isMultiDayCheckbox = document.getElementById('is_multi_day');
            const singleDayFields = document.getElementById('single-day-fields');
            const multiDayFields = document.getElementById('multi-day-fields');
            const addDayBtn = document.getElementById('add-day-btn');
            const eventDaysContainer = document.getElementById('event-days-container');
            let dayCounter = 0;

            // Function to toggle between single-day and multi-day fields
            function toggleEventFields() {
                if (isMultiDayCheckbox.checked) {
                    singleDayFields.style.display = 'none';
                    multiDayFields.style.display = 'block';
                    // If no days exist, add one by default
                    if (eventDaysContainer.children.length === 0) {
                        addEventDay();
                    }
                } else {
                    singleDayFields.style.display = 'grid';
                    multiDayFields.style.display = 'none';
                }
            }

            // Function to add a new event day
            function addEventDay() {
                dayCounter++;
                const dayElement = document.createElement('div');
                dayElement.className = 'event-day bg-gray-50 dark:bg-gray-700 p-4 rounded-lg';
                dayElement.dataset.dayId = dayCounter;

                dayElement.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-md font-medium">Day #${dayCounter}</h4>
                        <button type="button" class="remove-day-btn text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                            <input type="date" name="event_days[${dayCounter-1}][date]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                            <input type="time" name="event_days[${dayCounter-1}][start_time]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                            <input type="time" name="event_days[${dayCounter-1}][end_time]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                        </div>
                    </div>
                `;

                eventDaysContainer.appendChild(dayElement);

                // Add event listener to the remove button
                const removeBtn = dayElement.querySelector('.remove-day-btn');
                removeBtn.addEventListener('click', function() {
                    if (eventDaysContainer.children.length > 1) { // Ensure at least one day remains
                        dayElement.remove();
                    } else {
                        alert('At least one day is required for a multi-day event.');
                    }
                });
            }

            // Toggle fields based on initial checkbox state
            toggleEventFields();

            // Add event listeners
            isMultiDayCheckbox.addEventListener('change', function() {
                toggleEventFields();
                // Ensure required attributes are set correctly when toggling
                const multiDayFields = document.querySelectorAll('#multi-day-fields [required]');
                multiDayFields.forEach(field => {
                    field.required = isMultiDayCheckbox.checked;
                });
            });
            
            addDayBtn.addEventListener('click', addEventDay);
        });
    </script>
</x-app-layout>