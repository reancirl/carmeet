<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                {{ $event->name }}
            </h2>
            
            <div class="border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="eventTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-blue-600 rounded-t-lg active dark:text-white" id="details-tab" data-tabs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">
                            Event Details
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:text-white" id="upload-center-tab" data-tabs-target="#upload-center" type="button" role="tab" aria-controls="upload-center" aria-selected="false">
                            Upload Center
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:text-white" id="registrants-tab" data-tabs-target="#registrants" type="button" role="tab" aria-controls="registrants" aria-selected="false" disabled>
                            Car Registrants (Coming Soon)
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="eventTabContent">
                <!-- Event Details Tab Content -->
                <div class="block" id="details" role="tabpanel" aria-labelledby="details-tab">
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
                                                        {{ \Carbon\Carbon::parse($day->date)->format('m/d/Y (D)') }}: 
                                                        {{ \Carbon\Carbon::parse($day->start_time)->format('g:ia') }} - {{ \Carbon\Carbon::parse($day->end_time)->format('g:ia') }}
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
                                            <span class="font-bold">{{ $event->location_name }}</span><br>
                                            {{ $event->street }}<br>
                                            {{ $event->city }}, {{ $event->state }} {{ $event->zip_code }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h2 class="text-xl font-semibold mb-2">{{ __('Description') }}</h2>
                                <p class="text-gray-700 dark:text-gray-400">{{ $event->description }}</p>
                            </div>

                            <div>
                                <h2 class="text-xl font-semibold mb-2">{{ __('Organizer') }}</h2>
                                <p class="font-medium">{{ $event->organizer->name }}</p>
                            </div>

                            <div>
                                <h2 class="text-xl font-semibold mb-2">
                                    {{ __('Attendees') }} ({{ $event->attendees->count() }})
                                </h2>
                                <div class="space-y-2">
                                    @foreach($event->attendees as $attendee)
                                        <div class="flex items-center">
                                            <p class="flex-1 font-medium">{{ $attendee->name }}</p>
                                            @if($event->organizer_id === auth()->id() && auth()->user()->role == 'admin')
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

                            @if($event->organizer_id === auth()->id() || auth()->user()->role == 'admin')
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
            
            <!-- Upload Center Tab Content -->
            <div class="hidden" id="upload-center" role="tabpanel" aria-labelledby="upload-center-tab">
                @if($event->organizer_id === auth()->id())
                    <!-- Document Upload Section -->
                    <div id="documentUpload" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            @include('event-files._document-upload', ['event' => $event])
                        </div>
                    </div>
                @endif
                
                <!-- Event Documents Display -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-semibold mb-4">{{ __('Event Documents') }}</h2>
                        
                        @if($event->files->isEmpty())
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p>{{ __('No documents uploaded yet.') }}</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                @foreach($event->files as $file)
                                    <div class="border dark:border-gray-700 rounded-lg overflow-hidden shadow-sm group relative">
                                        @if(Str::contains($file->file_name, ['.jpg', '.jpeg', '.png', '.gif']))
                                            <!-- Image file -->
                                            <div class="relative h-40 bg-gray-200 dark:bg-gray-700">
                                                <img src="{{ Storage::url($file->file_url) }}" alt="{{ $file->file_name }}" 
                                                     class="w-full h-full object-cover">
                                                
                                                <!-- Download overlay - appears on hover -->
                                                <a href="{{ Storage::url($file->file_url) }}" 
                                                   download="{{ $file->file_name }}"
                                                   class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <div class="text-white flex flex-col items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        <span class="mt-2 text-sm">Download</span>
                                                    </div>
                                                </a>
                                                
                                                @if($file->visibility === 'approved_only')
                                                    <div class="absolute bottom-2 left-2">
                                                        <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded-full">
                                                            {{ __('For Approved Only') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Document file -->
                                            <div class="relative flex items-center justify-center h-40 bg-gray-100 dark:bg-gray-700">
                                                @php
                                                    $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                                @endphp
                                                
                                                <!-- File type icon -->
                                                @if($extension === 'pdf')
                                                    <svg class="w-16 h-16 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                                    </svg>
                                                @elseif(in_array($extension, ['doc', 'docx']))
                                                    <svg class="w-16 h-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-16 h-16 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                @endif
                                                
                                                <!-- Download overlay - appears on hover -->
                                                <a href="{{ Storage::url($file->file_url) }}" 
                                                   download="{{ $file->file_name }}"
                                                   class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <div class="text-white flex flex-col items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        <span class="mt-2 text-sm">Download</span>
                                                    </div>
                                                </a>
                                                
                                                @if($file->visibility === 'approved_only')
                                                    <div class="absolute bottom-2 left-2">
                                                        <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded-full">
                                                            {{ __('For Approved Only') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <div class="p-3">
                                            <h3 class="font-semibold text-sm truncate" title="{{ $file->file_name }}">
                                                {{ $file->file_name }}
                                            </h3>
                                            
                                            @if($file->description)
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 truncate" title="{{ $file->description }}">
                                                    {{ $file->description }}
                                                </p>
                                            @endif
                                            
                                            <div class="mt-3 flex justify-between items-center">
                                                <a href="{{ Storage::url($file->file_url) }}" target="_blank" 
                                                   class="text-blue-600 dark:text-blue-400 text-xs hover:underline">
                                                    {{ __('View') }}
                                                </a>
                                                
                                                @if($event->organizer_id === auth()->id())
                                                    <form action="{{ route('event-files.destroy', $file) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 dark:text-red-400 text-xs hover:underline"
                                                                onclick="return confirm('{{ __('Delete this file?') }}')">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Car Registrants Tab Content (Placeholder) -->
            <div class="hidden" id="registrants" role="tabpanel" aria-labelledby="registrants-tab">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-center py-8">
                            <h3 class="text-xl font-medium mb-2">{{ __('Coming Soon') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ __('Car registrants management will be available in a future update.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('[role="tab"]');
            const tabPanels = document.querySelectorAll('[role="tabpanel"]');
            
            // Function to activate a specific tab
            function activateTab(tabId) {
                // Find the tab with the matching data-tabs-target
                const targetTab = document.querySelector(`[data-tabs-target="#${tabId}"]`);
                
                if (targetTab && !targetTab.hasAttribute('disabled')) {
                    // Deactivate all tabs
                    tabs.forEach(t => {
                        if (!t.hasAttribute('disabled')) {
                            t.classList.remove('border-blue-600', 'active');
                            t.classList.add('border-transparent');
                            t.setAttribute('aria-selected', 'false');
                        }
                    });
                    
                    // Hide all tab panels
                    tabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    
                    // Activate target tab
                    targetTab.classList.remove('border-transparent');
                    targetTab.classList.add('border-blue-600', 'active');
                    targetTab.setAttribute('aria-selected', 'true');
                    
                    // Show corresponding panel
                    document.getElementById(tabId).classList.remove('hidden');
                }
            }
            
            // Add click event listeners to tabs
            tabs.forEach(tab => {
                if (!tab.hasAttribute('disabled')) {
                    tab.addEventListener('click', () => {
                        const panelId = tab.getAttribute('data-tabs-target').substring(1);
                        activateTab(panelId);
                    });
                }
            });
            
            // Check if we need to activate a specific tab from session
            @if(session('active_tab'))
                activateTab('{{ session('active_tab') }}');
            @endif

        });
        
        function previewDocuments() {
            const input = document.getElementById('documents');
            const descriptionsContainer = document.getElementById('documentDescriptions');
            
            // Clear previous descriptions
            descriptionsContainer.innerHTML = '';
            
            if (input.files.length > 0) {
                // For each file selected, create a description input
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    
                    const div = document.createElement('div');
                    div.className = 'mb-4';
                    
                    const label = document.createElement('label');
                    label.className = 'block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2';
                    label.textContent = `Description for ${file.name}`;
                    
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = `descriptions[${i}]`;
                    input.className = 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600';
                    input.placeholder = `Enter description for ${file.name}`;
                    input.required = true;
                    
                    div.appendChild(label);
                    div.appendChild(input);
                    descriptionsContainer.appendChild(div);
                }
            }
        }
    </script>
</x-app-layout>
