@php
    $fileExtension = pathinfo($file->file_name, PATHINFO_EXTENSION);
    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    $iconClass = '';
    $bgColor = 'bg-gray-100 dark:bg-gray-700';
    
    // Set icon based on file type
    switch(strtolower($fileExtension)) {
        case 'pdf':
            $iconClass = 'fas fa-file-pdf text-red-500';
            break;
        case 'doc':
        case 'docx':
            $iconClass = 'fas fa-file-word text-blue-500';
            break;
        case 'xls':
        case 'xlsx':
            $iconClass = 'fas fa-file-excel text-green-600';
            break;
        case 'ppt':
        case 'pptx':
            $iconClass = 'fas fa-file-powerpoint text-orange-500';
            break;
        case 'zip':
        case 'rar':
        case '7z':
            $iconClass = 'fas fa-file-archive text-yellow-500';
            break;
        default:
            $iconClass = 'fas fa-file-alt text-gray-500';
    }
    
    // Set background color for approved-only files
    if(isset($isApprovedOnly) && $isApprovedOnly) {
        $bgColor = 'bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500';
    }
@endphp

<div class="{{ $bgColor }} rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
    <div class="p-4">
        <div class="flex items-start space-x-4">
            @if($isImage)
                <div class="flex-shrink-0 w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-md overflow-hidden">
                    <img src="{{ $file->file_url }}" alt="{{ $file->description ?? 'Event image' }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-white dark:bg-gray-600 rounded-md">
                    <i class="{{ $iconClass }} text-3xl"></i>
                </div>
            @endif
            
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate" title="{{ $file->file_name }}">
                    {{ $file->file_name }}
                </p>
                @if($file->description)
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-2">
                        {{ $file->description }}
                    </p>
                @endif
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ strtoupper($fileExtension) }} • 
                        @if($file->created_at)
                            {{ $file->created_at->format('M d, Y') }}
                        @endif
                    </span>
                    @if(isset($isApprovedOnly) && $isApprovedOnly)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                            <i class="fas fa-lock mr-1"></i> Approved Only
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-3 flex justify-end">
            <a href="{{ $file->file_url }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               download>
                <i class="fas fa-download mr-1"></i> Download
            </a>
        </div>
    </div>
</div>
