<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="text-xl font-semibold mb-4">{{ __('Upload Center') }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('Upload files for approved event participants') }}</p>
        
        <form action="{{ route('events.upload-documents', $event) }}?tab=upload-center" method="POST" enctype="multipart/form-data" id="documentUploadForm">
            @csrf
            
            <div class="mb-4">
                <label for="documents" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Upload Documents') }} <span class="text-xs text-gray-500">(PDF, Word, Images - Max 10MB per file)</span>
                </label>
                
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    {{ __('PDFs, maps, media kits, or promotional assets for your event') }}
                </div>
                
                <div id="file-preview-container" class="mt-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4 hidden">
                    <!-- File previews will be dynamically inserted here -->
                </div>
                
                <input
                    type="file"
                    name="documents[]"
                    id="documents"
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    class="mt-1 block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                           file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                           @error('documents') border-red-500 @enderror"
                    multiple
                    required
                >
                @error('documents')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                @error('documents.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="visibility" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Visibility') }}
                </label>
                <select 
                    name="visibility" 
                    id="visibility"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                    required
                >
                    <option value="public">{{ __('Public - Visible to everyone') }}</option>
                    <option value="approved_only">{{ __('Approved Only - Visible to approved registrants only') }}</option>
                </select>
            </div>
            
            <div id="documentDescriptions" class="space-y-4 mb-6">
                <!-- Document descriptions will be added here by JavaScript -->
            </div>
            
            <div class="flex items-center justify-end">
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    {{ __('Upload Documents') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize file input change listener
    const fileInput = document.getElementById('documents');
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }
});

function handleFileSelect(event) {
    const fileInput = event.target;
    const previewContainer = document.getElementById('file-preview-container');
    const descriptionsContainer = document.getElementById('documentDescriptions');
    
    // Clear previous previews and descriptions
    previewContainer.innerHTML = '';
    descriptionsContainer.innerHTML = '';
    
    if (fileInput.files && fileInput.files.length > 0) {
        // Show the preview container
        previewContainer.classList.remove('hidden');
        
        // Create previews for each file
        for (let i = 0; i < fileInput.files.length; i++) {
            const file = fileInput.files[i];
            createFilePreview(file, i, previewContainer, descriptionsContainer);
        }
    } else {
        previewContainer.classList.add('hidden');
    }
}

function createFilePreview(file, index, previewContainer, descriptionsContainer) {
    // Create a unique ID for this preview
    const previewId = `file-preview-${Date.now()}-${index}`;
    const descriptionId = `desc-${previewId}`;
    
    // Create description input
    const descDiv = document.createElement('div');
    descDiv.className = 'mb-4';
    descDiv.id = descriptionId;
    
    const descLabel = document.createElement('label');
    descLabel.className = 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2';
    descLabel.textContent = `Description for ${file.name}`;
    
    const descInput = document.createElement('input');
    descInput.type = 'text';
    descInput.name = `descriptions[${index}]`;
    descInput.className = 'mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm';
    descInput.placeholder = `Enter description for ${file.name}`;
    descInput.required = true;
    descInput.dataset.fileIndex = index;
    
    descDiv.appendChild(descLabel);
    descDiv.appendChild(descInput);
    descriptionsContainer.appendChild(descDiv);
    
    // Create file preview card
    const previewCard = document.createElement('div');
    previewCard.className = 'border dark:border-gray-700 rounded-lg overflow-hidden shadow-sm relative';
    previewCard.id = previewId;
    previewCard.dataset.fileIndex = index;
    previewContainer.appendChild(previewCard);
    
    // Add remove button
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center z-10';
    removeButton.innerHTML = '×';  // × character for close
    removeButton.title = 'Remove file';
    removeButton.addEventListener('click', function() {
        removeFile(previewId, descriptionId, index);
    });
    previewCard.appendChild(removeButton);
    
    // Add file info section
    const fileInfo = document.createElement('div');
    fileInfo.className = 'p-3';
    fileInfo.innerHTML = `
        <p class="font-medium text-sm truncate" title="${file.name}">${file.name}</p>
        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
    `;
    
    // Create preview based on file type
    if (file.type.startsWith('image/')) {
        // For image files, create a placeholder first
        const imageContainer = document.createElement('div');
        imageContainer.className = 'h-40 bg-gray-200 dark:bg-gray-700 flex items-center justify-center';
        imageContainer.innerHTML = '<div class="text-gray-400">Loading...</div>';
        previewCard.appendChild(imageContainer);
        
        // Load the image
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-40 object-cover';
            
            // Replace placeholder with image
            imageContainer.innerHTML = '';
            imageContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    } else {
        // For non-image files
        const iconContainer = document.createElement('div');
        iconContainer.className = 'h-40 bg-gray-100 dark:bg-gray-700 flex items-center justify-center';
        
        // Choose icon based on file type
        let iconHTML = '<i class="far fa-file"></i>';
        if (file.name.endsWith('.pdf')) {
            iconHTML = '<i class="far fa-file-pdf"></i>';
        } else if (file.name.endsWith('.doc') || file.name.endsWith('.docx')) {
            iconHTML = '<i class="far fa-file-word"></i>';
        }
        
        iconContainer.innerHTML = `<div class="text-4xl text-gray-400">${iconHTML}</div>`;
        previewCard.appendChild(iconContainer);
    }
    
    // Add file info after preview
    previewCard.appendChild(fileInfo);
}

function removeFile(previewId, descriptionId, index) {
    // Get the elements to remove
    const previewElement = document.getElementById(previewId);
    const descriptionElement = document.getElementById(descriptionId);
    
    if (previewElement) {
        previewElement.remove();
    }
    
    if (descriptionElement) {
        descriptionElement.remove();
    }
    
    // Handle the file input - we can't directly modify the FileList, so we need to recreate it
    // This is a trick to maintain the selection without the removed file
    updateFileInputAfterRemoval(index);
}

function updateFileInputAfterRemoval(indexToRemove) {
    const fileInput = document.getElementById('documents');
    const previewContainer = document.getElementById('file-preview-container');
    
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) return;
    
    // Create a new DataTransfer object
    const dt = new DataTransfer();
    
    // Add all files except the one to remove to the DataTransfer object
    for (let i = 0; i < fileInput.files.length; i++) {
        if (i !== indexToRemove) {
            dt.items.add(fileInput.files[i]);
        }
    }
    
    // Update the file input files property with the new file list
    fileInput.files = dt.files;
    
    // If no files are left, hide the preview container
    if (fileInput.files.length === 0) {
        previewContainer.classList.add('hidden');
        document.getElementById('documentDescriptions').innerHTML = '';
    }
    
    // If there are still files, regenerate the previews to update indices
    if (fileInput.files.length > 0 && previewContainer.children.length === 0) {
        handleFileSelect({ target: fileInput });
    }
}
</script>
