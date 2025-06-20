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
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm mb-6">
                                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Description</h4>
                                    <div class="text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $carProfile->description }}</div>
                                </div>
                            @endif

                            @if ($carProfile->mod_tags)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm mb-6">
                                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Mod Tags</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $carProfile->mod_tags) as $tag)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                {{ trim($tag) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($carProfile->facebook || $carProfile->instagram || $carProfile->youtube || $carProfile->tiktok || $carProfile->website)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Social Media</h4>
                                    <div class="space-y-2">
                                        @if($carProfile->facebook)
                                            <div class="flex items-center">
                                                <span class="text-gray-600 dark:text-gray-400 w-24">Facebook:</span>
                                                <a href="{{ $carProfile->facebook }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                                    {{ parse_url($carProfile->facebook, PHP_URL_HOST) }}{{ parse_url($carProfile->facebook, PHP_URL_PATH) }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($carProfile->instagram)
                                            <div class="flex items-center">
                                                <span class="text-gray-600 dark:text-gray-400 w-24">Instagram:</span>
                                                <a href="{{ $carProfile->instagram }}" target="_blank" class="text-pink-600 hover:underline dark:text-pink-400">
                                                    {{ parse_url($carProfile->instagram, PHP_URL_HOST) }}{{ parse_url($carProfile->instagram, PHP_URL_PATH) }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($carProfile->youtube)
                                            <div class="flex items-center">
                                                <span class="text-gray-600 dark:text-gray-400 w-24">YouTube:</span>
                                                <a href="{{ $carProfile->youtube }}" target="_blank" class="text-red-600 hover:underline dark:text-red-400">
                                                    {{ parse_url($carProfile->youtube, PHP_URL_HOST) }}{{ parse_url($carProfile->youtube, PHP_URL_PATH) }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($carProfile->tiktok)
                                            <div class="flex items-center">
                                                <span class="text-gray-600 dark:text-gray-400 w-24">TikTok:</span>
                                                <a href="{{ $carProfile->tiktok }}" target="_blank" class="text-gray-800 hover:underline dark:text-gray-200">
                                                    {{ parse_url($carProfile->tiktok, PHP_URL_HOST) }}{{ parse_url($carProfile->tiktok, PHP_URL_PATH) }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($carProfile->website)
                                            <div class="flex items-center">
                                                <span class="text-gray-600 dark:text-gray-400 w-24">Website:</span>
                                                <a href="{{ $carProfile->website }}" target="_blank" class="text-indigo-600 hover:underline dark:text-indigo-400">
                                                    {{ parse_url($carProfile->website, PHP_URL_HOST) }}{{ parse_url($carProfile->website, PHP_URL_PATH) }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
