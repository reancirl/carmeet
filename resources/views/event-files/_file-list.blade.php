<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">{{ __($title) }}</h2>
            @if($event->organizer_id === auth()->id())
                <a href="#{{ $uploadFormId }}" class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-sm">
                    {{ __('Upload New') }}
                </a>
            @endif
        </div>
        
        @if($files->isEmpty())
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <p>{{ __('No files uploaded yet.') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($files as $file)
                    <div class="border dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
                        @if(Str::contains($file->file_name, ['.jpg', '.jpeg', '.png', '.gif']))
                            <!-- Image file -->
                            <div class="relative h-40 bg-gray-200 dark:bg-gray-700">
                                <img src="{{ Storage::url($file->file_url) }}" alt="{{ $file->file_name }}" 
                                     class="w-full h-full object-cover">
                                
                                @if($file->file_type === 'car_photo')
                                    <div class="absolute top-2 right-2">
                                        @if($file->is_display_photo)
                                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                                {{ __('Display Photo') }}
                                            </span>
                                        @elseif($event->organizer_id === auth()->id())
                                            <form action="{{ route('event-files.set-display', $file) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                                    {{ __('Set As Display') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                                
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
                            <div class="relative h-40 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <div class="text-4xl text-gray-400">
                                    @if(Str::endsWith($file->file_name, '.pdf'))
                                        <i class="far fa-file-pdf"></i>
                                    @elseif(Str::endsWith($file->file_name, ['.doc', '.docx']))
                                        <i class="far fa-file-word"></i>
                                    @else
                                        <i class="far fa-file"></i>
                                    @endif
                                </div>
                                
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
