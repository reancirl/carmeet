@props(['event'])

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        @if($event->organizer_id === auth()->id())
            <form action="{{ route('events.upload-documents', $event) }}" method="POST" enctype="multipart/form-data" class="mb-8">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="documents" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Upload Documents') }}
                        </label>
                        <input type="file" name="documents[]" id="documents" multiple 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-100 dark:hover:file:bg-blue-800"
                               onchange="previewDocuments()">
                        <div id="documentDescriptions" class="mt-2 space-y-2">
                            <!-- Document descriptions will be added here by JavaScript -->
                        </div>
                        @error('documents')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                            {{ __('Upload Files') }}
                        </button>
                    </div>
                </div>
            </form>
        @endif

        @if($event->files->count() > 0)
            <h3 class="text-lg font-medium mb-4">{{ __('Uploaded Documents') }}</h3>
            <div class="space-y-4">
                @foreach($event->files as $file)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                        <div class="flex items-center space-x-3">
                            @if(in_array(strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <div class="flex-shrink-0 w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-md overflow-hidden">
                                    <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->original_name }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-md">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $file->original_name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $file->created_at->format('M d, Y H:i') }} • {{ number_format($file->file_size / 1024, 1) }} KB
                                </p>
                                @if($file->description)
                                    <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">{{ $file->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('event-files.download', $file) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                            @if($event->organizer_id === auth()->id())
                                <form action="{{ route('event-files.destroy', $file) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                                            onclick="return confirm('{{ __('Delete this file?') }}')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                {{ __('No documents have been uploaded yet.') }}
            </p>
        @endif
    </div>
</div>
