<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $carProfile->year }} {{ $carProfile->make }} {{ $carProfile->model }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end space-x-2">
                <a href="{{ route('car-profiles.edit', $carProfile->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('car-profiles.destroy', $carProfile->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this car?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Delete') }}
                    </button>
                </form>
                <a href="{{ route('car-profiles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Garage') }}
                </a>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Car Images -->
                    @if (!empty($carProfile->image_urls) && count($carProfile->image_urls) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2 dark:border-gray-700">{{ __('Images') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($carProfile->image_urls as $imageUrl)
                                    <div class="relative group">
                                        <img src="{{ $imageUrl }}" alt="{{ $carProfile->make }} {{ $carProfile->model }}" class="w-full h-64 object-cover rounded-lg shadow-md transition-all duration-300 group-hover:shadow-lg">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Car Details -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2 dark:border-gray-700">Car Details</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-4">Basic Information</h4>
                            <div class="space-y-3">
                                <div class="flex border-b border-gray-200 dark:border-gray-600 pb-2">
                                    <span class="font-medium w-24 text-gray-600 dark:text-gray-400">Make:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $carProfile->make }}</span>
                                </div>
                                <div class="flex border-b border-gray-200 dark:border-gray-600 pb-2">
                                    <span class="font-medium w-24 text-gray-600 dark:text-gray-400">Model:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $carProfile->model }}</span>
                                </div>
                                <div class="flex border-b border-gray-200 dark:border-gray-600 pb-2">
                                    <span class="font-medium w-24 text-gray-600 dark:text-gray-400">Year:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $carProfile->year }}</span>
                                </div>
                                @if ($carProfile->trim)
                                    <div class="flex border-b border-gray-200 dark:border-gray-600 pb-2">
                                        <span class="font-medium w-24 text-gray-600 dark:text-gray-400">Trim:</span>
                                        <span class="text-gray-800 dark:text-gray-200">{{ $carProfile->trim }}</span>
                                    </div>
                                @endif
                                <div class="flex border-b border-gray-200 dark:border-gray-600 pb-2">
                                    <span class="font-medium w-24 text-gray-600 dark:text-gray-400">Color:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $carProfile->color }}</span>
                                </div>
                                @if ($carProfile->plate)
                                    <div class="flex border-b border-gray-200 dark:border-gray-600 pb-2">
                                        <span class="font-medium w-24 text-gray-600 dark:text-gray-400">Plate:</span>
                                        <span class="text-gray-800 dark:text-gray-200">{{ $carProfile->plate }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            @if ($carProfile->mods)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm mb-6">
                                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Modifications</h4>
                                    <div class="text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $carProfile->mods }}</div>
                                </div>
                            @endif

                            @if ($carProfile->description)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Description</h4>
                                    <div class="text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $carProfile->description }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
