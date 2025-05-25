<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Garage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('car-profiles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Add New Car') }}
                        </a>
                    </div>

                    @if (count($carProfiles) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($carProfiles as $carProfile)
                                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="relative h-48">
                                        @if (!empty($carProfile->image_urls) && count($carProfile->image_urls) > 0)
                                            <img src="{{ $carProfile->image_urls[0] }}" alt="{{ $carProfile->make }} {{ $carProfile->model }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <p class="text-gray-500 dark:text-gray-400">No image available</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold mb-2">{{ $carProfile->year }} {{ $carProfile->make }} {{ $carProfile->model }}</h3>
                                        <div class="mb-3">
                                            @if ($carProfile->trim)
                                                <p class="text-sm text-gray-600 dark:text-gray-300">Trim: {{ $carProfile->trim }}</p>
                                            @endif
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Color: {{ $carProfile->color }}</p>
                                        </div>
                                        <div class="flex justify-between">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('car-profiles.show', $carProfile->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-sm">View</a>
                                                <a href="{{ route('car-profiles.edit', $carProfile->id) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 text-sm">Edit</a>
                                            </div>
                                            <form action="{{ route('car-profiles.destroy', $carProfile->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this car?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't added any cars to your garage yet.</p>
                            <a href="{{ route('car-profiles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Add Your First Car') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
