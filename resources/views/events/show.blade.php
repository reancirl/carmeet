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
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:text-white" id="drivers-tab" data-tabs-target="#drivers" type="button" role="tab" aria-controls="drivers" aria-selected="false">
                            Drivers
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:text-white" id="attendees-tab" data-tabs-target="#attendees" type="button" role="tab" aria-controls="attendees" aria-selected="false">
                            Attendees
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:text-white" id="instructions-tab" data-tabs-target="#instructions" type="button" role="tab" aria-controls="instructions" aria-selected="false">
                            Event Day Instructions
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
                    @include('events.components.event-details', ['event' => $event])
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

                                                    <form action="{{ route('event-files.toggle-visibility', $file) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-blue-600 dark:text-blue-400 text-xs hover:underline focus:outline-none"
                                                                title="{{ $file->visibility === 'approved_only' ? 'Make visible to everyone' : 'Restrict to approved only' }}">
                                                            {{ $file->visibility === 'approved_only' ? __('Make Public') : __('Restrict Access') }}
                                                        </button>
                                                    </form>
                                                    
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
                
                <!-- Drivers Tab Content -->
                <div class="hidden" id="drivers" role="tabpanel" aria-labelledby="drivers-tab">
                    @include('events.components.drivers', ['event' => $event])
                </div>
                
                <!-- Attendees Tab Content -->
                <div class="hidden" id="attendees" role="tabpanel" aria-labelledby="attendees-tab">
                    @include('events.components.event-attendees', ['event' => $event])
                </div>
                
                <!-- Event Day Instructions Tab Content -->
                <div class="hidden" id="instructions" role="tabpanel" aria-labelledby="instructions-tab">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Event Day Instructions</h2>
                                @can('manageDayInstructions', $event)
                                    <a href="{{ route('events.day-instructions.edit', $event->slug) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Instructions
                                    </a>
                                @endcan
                            </div>
                            
                            <div class="space-y-6">
                                @php
                                    $instructions = $event->dayInstructions;
                                @endphp
                                
                                @if(!$instructions || (!$instructions->arrival_instructions && !$instructions->gate_instructions && !$instructions->items_to_bring && !$instructions->important_notes))
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg text-yellow-700 dark:text-yellow-200">
                                        <p>No event day instructions have been added yet.</p>
                                        @can('manageDayInstructions', $event)
                                            <p class="mt-2">Click the "Edit Instructions" button to add instructions for attendees.</p>
                                        @endcan
                                    </div>
                                @else
                                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-6">
                                        @if($instructions->arrival_instructions)
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Arrival Instructions</h3>
                                                    <div class="mt-2 text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $instructions->arrival_instructions }}</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($instructions->gate_instructions)
                                            <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Entrance & Parking</h3>
                                                        <div class="mt-2 text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $instructions->gate_instructions }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($instructions->items_to_bring)
                                            <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">What to Bring</h3>
                                                        <div class="mt-2 text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $instructions->items_to_bring }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($instructions->important_notes)
                                            <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Important Notes</h3>
                                                        <div class="mt-2 text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $instructions->important_notes }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
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
            
            // Function to activate a tab by ID
            function activateTab(tabId) {
                // Hide all tab panels and deactivate all tabs
                tabPanels.forEach(panel => panel.classList.add('hidden'));
                tabs.forEach(tab => {
                    tab.setAttribute('aria-selected', 'false');
                    tab.classList.remove('border-blue-600', 'dark:text-white');
                    tab.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                });
                
                // Show the selected tab panel and activate the tab
                const selectedTab = document.querySelector(`[data-tabs-target="#${tabId}"]`);
                const selectedPanel = document.getElementById(tabId);
                
                if (selectedTab && selectedPanel) {
                    selectedTab.setAttribute('aria-selected', 'true');
                    selectedTab.classList.add('border-blue-600', 'dark:text-white');
                    selectedTab.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                    selectedPanel.classList.remove('hidden');
                    
                    // Update URL with the tab ID as hash
                    history.pushState(null, null, `#${tabId}`);
                }
            }
            
            // Check for URL hash on page load
            const hash = window.location.hash.substring(1);
            if (hash && ['details', 'upload-center', 'drivers'].includes(hash)) {
                activateTab(hash);
            } else {
                // Activate the first tab by default if no valid hash is present
                const activeTab = document.querySelector('[role="tab"][aria-selected="true"]');
                if (!activeTab && tabs.length > 0) {
                    tabs[0].setAttribute('aria-selected', 'true');
                    const panelId = tabs[0].getAttribute('data-tabs-target').substring(1);
                    document.getElementById(panelId).classList.remove('hidden');
                }
            }
            
            // Tab click handler
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
            
            // ==========================================
            // Car Registrations Functionality
            // ==========================================
            
            // Handle status dropdown changes
            const statusSelects = document.querySelectorAll('.status-select');
            statusSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const form = this.closest('form');
                    form.submit();
                });
            });
            
            // Handle paid checkbox changes
            const paidCheckboxes = document.querySelectorAll('.paid-checkbox');
            paidCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const form = this.closest('form');
                    form.submit();
                });
            });
            
            // Registration Details Modal
            const modal = document.getElementById('registration-modal');
            const closeModalButton = document.getElementById('close-modal');
            const viewDetailsButtons = document.querySelectorAll('.view-details');
            const modalContent = document.getElementById('modal-content');
            
            // Modal action buttons
            const approveButton = document.getElementById('approve-btn');
            const denyButton = document.getElementById('deny-btn');
            const waitlistButton = document.getElementById('waitlist-btn');
            const modalPaidCheckbox = document.getElementById('modal-paid');
            const paymentNoteTextarea = document.getElementById('payment-note');
            const savePaymentButton = document.getElementById('save-payment');
            
            let currentRegistrationId = null;
            
            // Open modal when View Details is clicked
            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const registrationId = this.getAttribute('data-registration-id');
                    currentRegistrationId = registrationId;
                    
                    // Fetch registration details via AJAX
                    fetch(`/registrations/${registrationId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            // Populate modal with registration details
                            let content = `
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-medium text-lg mb-3">${data.user.name}</h4>
                                        <p class="text-gray-600 dark:text-gray-400">${data.user.email}</p>
                                        
                                        <div class="mt-4">
                                            <h5 class="font-medium">Car Details</h5>
                                            <p>${data.car.year} ${data.car.make} ${data.car.model} ${data.car.trim || ''}</p>
                                            <p>Color: ${data.car.color}</p>
                                            ${data.car.plate ? `<p>Plate: ${data.car.plate}</p>` : ''}
                                        </div>
                                        
                                        ${data.registration.crew_name ? `
                                        <div class="mt-4">
                                            <h5 class="font-medium">Crew</h5>
                                            <p>${data.registration.crew_name}</p>
                                        </div>` : ''}
                                        
                                        ${data.registration.notes_to_organizer ? `
                                        <div class="mt-4">
                                            <h5 class="font-medium">Notes to Organizer</h5>
                                            <p>${data.registration.notes_to_organizer}</p>
                                        </div>` : ''}
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-lg mb-3">Car Photos</h4>
                                        <div class="grid grid-cols-2 gap-2">
                                            ${data.car.image_urls && Array.isArray(data.car.image_urls) ? 
                                                data.car.image_urls.map(url => `
                                                    <div>
                                                        <img src="${url}" class="w-full h-32 object-cover rounded" alt="Car photo">
                                                    </div>
                                                `).join('') : 
                                                '<p>No photos available</p>'
                                            }
                                        </div>
                                        
                                        ${data.car.mods ? `
                                        <div class="mt-4">
                                            <h5 class="font-medium">Modifications</h5>
                                            <p>${data.car.mods}</p>
                                        </div>` : ''}
                                        
                                        ${data.car.description ? `
                                        <div class="mt-4">
                                            <h5 class="font-medium">Description</h5>
                                            <p>${data.car.description}</p>
                                        </div>` : ''}
                                    </div>
                                </div>
                            `;
                            
                            modalContent.innerHTML = content;
                            
                            // Set current status in the modal action buttons
                            const currentStatus = data.registration.status;
                            approveButton.classList.toggle('ring-2', currentStatus === 'approved');
                            denyButton.classList.toggle('ring-2', currentStatus === 'denied');
                            waitlistButton.classList.toggle('ring-2', currentStatus === 'waitlist');
                            
                            // Set payment info
                            modalPaidCheckbox.checked = data.registration.is_paid;
                            paymentNoteTextarea.value = data.registration.payment_note || '';
                            
                            modal.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error fetching registration details:', error);
                        });
                });
            });
            
            // Close modal when close button is clicked
            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden');
                currentRegistrationId = null;
            });
            
            // Close modal when clicking outside
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    currentRegistrationId = null;
                }
            });
            
            // Action buttons functionality
            function updateRegistrationStatus(status) {
                if (!currentRegistrationId) return;
                
                fetch(`/registrations/${currentRegistrationId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the status in the table without refreshing
                        const statusSelect = document.querySelector(`.status-select[data-registration-id="${currentRegistrationId}"]`);
                        if (statusSelect) {
                            statusSelect.value = status;
                        }
                        
                        // Highlight the active button
                        approveButton.classList.toggle('ring-2', status === 'approved');
                        denyButton.classList.toggle('ring-2', status === 'denied');
                        waitlistButton.classList.toggle('ring-2', status === 'waitlist');
                    }
                })
                .catch(error => {
                    console.error('Error updating registration status:', error);
                });
            }
            
            approveButton.addEventListener('click', function() {
                updateRegistrationStatus('approved');
            });
            
            denyButton.addEventListener('click', function() {
                updateRegistrationStatus('denied');
            });
            
            waitlistButton.addEventListener('click', function() {
                updateRegistrationStatus('waitlist');
            });
            
            // Save payment info
            savePaymentButton.addEventListener('click', function() {
                if (!currentRegistrationId) return;
                
                const isPaid = modalPaidCheckbox.checked;
                const paymentNote = paymentNoteTextarea.value;
                
                fetch(`/registrations/${currentRegistrationId}/payment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        is_paid: isPaid,
                        payment_note: paymentNote
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the payment status in the table
                        const checkbox = document.querySelector(`#paid-${currentRegistrationId}`);
                        if (checkbox) {
                            checkbox.checked = isPaid;
                        }
                        
                        // Update the payment note in the table
                        const noteElement = checkbox?.closest('td')?.querySelector('.text-xs');
                        if (noteElement) {
                            noteElement.textContent = paymentNote;
                            noteElement.setAttribute('title', paymentNote);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating payment info:', error);
                });
            });
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
