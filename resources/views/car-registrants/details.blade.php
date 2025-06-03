<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Car Registration Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            {{ $registration->carProfile->user->name }} ({{ $registration->carProfile->user->email }})
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                            {{ $registration->carProfile->year }} {{ $registration->carProfile->make }} {{ $registration->carProfile->model }}
                            @if($registration->carProfile->trim)
                                {{ $registration->carProfile->trim }}
                            @endif
                        </p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <dl>
                            <!-- Registration Status -->
                            <div class="bg-gray-50 dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registration Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $registration->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                        {{ $registration->status === 'denied' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                        {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                        {{ $registration->status === 'waitlist' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </dd>
                            </div>

                            <!-- Payment Status -->
                            <div class="bg-white dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $registration->is_paid ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $registration->is_paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </dd>
                            </div>

                            @if($registration->payment_note)
                            <div class="bg-gray-50 dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Note</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    {{ $registration->payment_note }}
                                </dd>
                            </div>
                            @endif

                            <!-- Car Details Section -->
                            <div class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Car Details</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2 space-y-4">
                                    <!-- Year, Make, Model -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <p class="font-medium">Year</p>
                                            <p>{{ $registration->carProfile->year }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium">Make</p>
                                            <p>{{ $registration->carProfile->make }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium">Model</p>
                                            <p>{{ $registration->carProfile->model }}</p>
                                        </div>
                                    </div>

                                    <!-- Trim, Color, Plate -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        @if($registration->carProfile->trim)
                                        <div>
                                            <p class="font-medium">Trim</p>
                                            <p>{{ $registration->carProfile->trim }}</p>
                                        </div>
                                        @endif
                                        <div>
                                            <p class="font-medium">Color</p>
                                            <div class="flex items-center">
                                                <span class="w-4 h-4 rounded-full mr-2 border border-gray-300" style="background-color: {{ $registration->carProfile->color }};"></span>
                                                <span>{{ ucfirst($registration->carProfile->color) }}</span>
                                            </div>
                                        </div>
                                        @if($registration->carProfile->plate)
                                        <div>
                                            <p class="font-medium">License Plate</p>
                                            <p>{{ $registration->carProfile->plate }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Modifications -->
                                    @if($registration->carProfile->mods)
                                    <div>
                                        <p class="font-medium">Modifications</p>
                                        <p class="whitespace-pre-line">{{ $registration->carProfile->mods }}</p>
                                    </div>
                                    @endif

                                    <!-- Description -->
                                    @if($registration->carProfile->description)
                                    <div>
                                        <p class="font-medium">Description</p>
                                        <p class="whitespace-pre-line">{{ $registration->carProfile->description }}</p>
                                    </div>
                                    @endif

                                    <!-- Car Images -->
                                    @if($registration->carProfile->image_urls && count($registration->carProfile->image_urls) > 0)
                                    <div>
                                        <p class="font-medium mb-2">Car Images</p>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            @foreach($registration->carProfile->image_urls as $index => $imageUrl)
                                                <div class="aspect-w-16 aspect-h-9 overflow-hidden rounded-lg cursor-pointer hover:opacity-90 transition-opacity" onclick="openLightbox({{ $index }})">
                                                    <img src="{{ $imageUrl }}" alt="Car image {{ $index + 1 }}" class="w-full h-full object-cover">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Lightbox Modal -->
                                    <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4 hidden">
                                        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        <button onclick="navigateImage(-1)" class="absolute left-4 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 focus:outline-none">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="max-w-4xl w-full max-h-[90vh] flex items-center justify-center">
                                            <img id="lightbox-image" src="" alt="" class="max-w-full max-h-[90vh] object-contain">
                                        </div>
                                        <button onclick="navigateImage(1)" class="absolute right-4 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 focus:outline-none">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <script>
                                        let currentImageIndex = 0;
                                        const images = @json($registration->carProfile->image_urls);

                                        function openLightbox(index) {
                                            currentImageIndex = index;
                                            updateLightboxImage();
                                            document.getElementById('lightbox').classList.remove('hidden');
                                            document.body.style.overflow = 'hidden';
                                        }

                                        function closeLightbox() {
                                            document.getElementById('lightbox').classList.add('hidden');
                                            document.body.style.overflow = 'auto';
                                        }

                                        function navigateImage(direction) {
                                            currentImageIndex = (currentImageIndex + direction + images.length) % images.length;
                                            updateLightboxImage();
                                        }

                                        function updateLightboxImage() {
                                            const lightboxImage = document.getElementById('lightbox-image');
                                            lightboxImage.src = images[currentImageIndex];
                                            lightboxImage.alt = `Car image ${currentImageIndex + 1}`;
                                        }

                                        // Close lightbox when clicking outside the image
                                        document.getElementById('lightbox').addEventListener('click', function(e) {
                                            if (e.target === this) {
                                                closeLightbox();
                                            }
                                        });

                                        // Keyboard navigation
                                        document.addEventListener('keydown', function(e) {
                                            const lightbox = document.getElementById('lightbox');
                                            if (lightbox.classList.contains('hidden')) return;

                                            if (e.key === 'Escape') {
                                                closeLightbox();
                                            } else if (e.key === 'ArrowLeft') {
                                                navigateImage(-1);
                                            } else if (e.key === 'ArrowRight') {
                                                navigateImage(1);
                                            }
                                        });
                                    </script>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registration Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    {{ $registration->created_at->format('M d, Y h:i A') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0">
                    <a href="{{ route('events.show', $registration->event) }}#registrants" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Back to Event
                    </a>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <a href="{{ route('car-registrants.edit-status', $registration) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Update Status
                        </a>
                        <a href="{{ route('car-registrants.edit-payment', $registration) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Update Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
