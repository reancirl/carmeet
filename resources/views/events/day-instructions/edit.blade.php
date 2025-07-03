<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Event Day Instructions') }}
            </h2>
            <a href="{{ route('events.show', $event->slug) }}#instructions" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                &larr; Back to Event
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('events.day-instructions.update', $event->slug) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Arrival Instructions -->
                            <div>
                                <x-input-label for="arrival_instructions" :value="__('Arrival Instructions')" />
                                <textarea 
                                    id="arrival_instructions" 
                                    name="arrival_instructions" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                                    rows="3"
                                >{{ old('arrival_instructions', $instructions->arrival_instructions) }}</textarea>
                                <x-input-error :messages="$errors->get('arrival_instructions')" class="mt-2" />
                            </div>
                            
                            <!-- Gate Instructions -->
                            <div>
                                <x-input-label for="gate_instructions" :value="__('Gate Instructions')" />
                                <textarea 
                                    id="gate_instructions" 
                                    name="gate_instructions" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                                    rows="3"
                                >{{ old('gate_instructions', $instructions->gate_instructions) }}</textarea>
                                <x-input-error :messages="$errors->get('gate_instructions')" class="mt-2" />
                            </div>
                            
                            <!-- Items to Bring -->
                            <div>
                                <x-input-label for="items_to_bring" :value="__('What to Bring')" />
                                <textarea 
                                    id="items_to_bring" 
                                    name="items_to_bring" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                                    rows="3"
                                >{{ old('items_to_bring', $instructions->items_to_bring) }}</textarea>
                                <x-input-error :messages="$errors->get('items_to_bring')" class="mt-2" />
                            </div>
                            
                            <!-- Important Notes -->
                            <div>
                                <x-input-label for="important_notes" :value="__('Important Notes')" />
                                <textarea 
                                    id="important_notes" 
                                    name="important_notes" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                                    rows="3"
                                >{{ old('important_notes', $instructions->important_notes) }}</textarea>
                                <x-input-error :messages="$errors->get('important_notes')" class="mt-2" />
                            </div>
                            
                            <div class="flex items-center justify-end mt-6">
                                <x-primary-button type="submit">
                                    {{ __('Save Instructions') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
