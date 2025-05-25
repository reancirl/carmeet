<x-public-layout :title="'Register for ' . $event->name">
    <div class="flex-grow w-full lg:max-w-4xl mx-auto px-6 lg:px-8 py-8 space-y-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-6">Register for {{ $event->name }}</h1>
                
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
                
                @if (session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                        <p>{{ session('warning') }}</p>
                    </div>
                @endif
                
                <form action="{{ route('event-registrations.store', $event) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Car Profile Selection -->
                        <div>
                            <label for="car_profile_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Select Car') }}
                            </label>
                            <select 
                                id="car_profile_id" 
                                name="car_profile_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                       @error('car_profile_id') border-red-500 @enderror"
                                required
                            >
                                <option value="">{{ __('Choose from your saved car profiles') }}</option>
                                @foreach($carProfiles as $carProfile)
                                    <option value="{{ $carProfile->id }}" {{ old('car_profile_id') == $carProfile->id ? 'selected' : '' }}>
                                        {{ $carProfile->year }} {{ $carProfile->make }} {{ $carProfile->model }} ({{ $carProfile->color }})
                                    </option>
                                @endforeach
                            </select>
                            @error('car_profile_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Class (Optional) -->
                        <div>
                            <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Class (Optional)') }}
                            </label>
                            <select 
                                id="class" 
                                name="class" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                       @error('class') border-red-500 @enderror"
                            >
                                <option value="">{{ __('Select class') }}</option>
                                <option value="VIP" {{ old('class') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Static" {{ old('class') == 'Static' ? 'selected' : '' }}>Static</option>
                                <option value="Participant" {{ old('class') == 'Participant' ? 'selected' : '' }}>Participant</option>
                            </select>
                            @error('class')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <!-- Crew Name (Optional) -->
                        <div>
                            <label for="crew_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Crew Name (Optional)') }}
                            </label>
                            <input
                                type="text"
                                id="crew_name"
                                name="crew_name"
                                value="{{ old('crew_name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                       @error('crew_name') border-red-500 @enderror"
                                placeholder="{{ __('Optional - list your crew for grouped parking') }}"
                            >
                            @error('crew_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Notes to Organizer (Optional) -->
                        <div class="md:col-span-2">
                            <label for="notes_to_organizer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Notes to Organizer (Optional)') }}
                            </label>
                            <textarea
                                id="notes_to_organizer"
                                name="notes_to_organizer"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                       @error('notes_to_organizer') border-red-500 @enderror"
                                placeholder="{{ __('Anything else you want the organizer to know') }}"
                            >{{ old('notes_to_organizer') }}</textarea>
                            @error('notes_to_organizer')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Agreement Checkbox -->
                        <div class="md:col-span-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input
                                        id="agree_to_terms"
                                        name="agree_to_terms"
                                        type="checkbox"
                                        class="h-4 w-4 text-indigo-600 dark:text-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-600 border-gray-300 dark:border-gray-600 rounded
                                               @error('agree_to_terms') border-red-500 @enderror"
                                        required
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="agree_to_terms" class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('I agree to the event rules and liability waiver') }}
                                    </label>
                                    @error('agree_to_terms')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <a
                            href="{{ route('public.events.show', $event) }}"
                            class="mr-3 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        >
                            {{ __('Cancel') }}
                        </a>
                        <button
                            type="submit"
                            class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
                        >
                            {{ __('Submit Registration') }}
                        </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-public-layout>
