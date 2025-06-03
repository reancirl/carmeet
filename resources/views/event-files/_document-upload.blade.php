<div class="bg-white dark:bg-gray-800 shadow rounded-lg mt-4">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="text-xl font-semibold mb-4">{{ __('Upload Center') }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            {{ __('Upload files for approved event participants') }}
        </p>
        <form
            action="{{ route('events.upload-documents', $event) }}"
            method="POST"
            enctype="multipart/form-data"
            id="documentUploadForm"
            onsubmit="return validateForm()"
        >
            @csrf

            {{-- 1 File Input --}}
            <div class="mb-4">
                <label for="documents" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Upload Documents') }}
                    <span class="text-xs text-gray-500">(PDF, Word, Images - Max 10MB per file)</span>
                </label>

                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    {{ __('PDFs, maps, media kits, or promotional assets for your event') }}
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

            {{-- 2 Visibility --}}
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

            {{-- 3 Container for file previews --}}
            <div id="file-preview-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                <!-- Preview thumbnails will be inserted here -->
            </div>
            
            <style>
                .preview-item {
                    position: relative;
                    transition: all 0.2s ease;
                }
                .preview-item:hover .remove-btn {
                    opacity: 1;
                }
                .remove-btn {
                    position: absolute;
                    top: 0.25rem;
                    right: 0.25rem;
                    background: rgba(239, 68, 68, 0.9);
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 1.5rem;
                    height: 1.5rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    opacity: 0;
                    transition: opacity 0.2s ease;
                }
                .remove-btn:hover {
                    background: #dc2626;
                }
                .remove-btn:focus {
                    outline: none;
                    box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.5);
                }
            </style>

            {{-- 4 Container for dynamically‐created "file_names[]" and "descriptions[]" --}}
            <div id="documentDescriptions" class="space-y-4 mb-6">
                <p
                    class="text-sm text-gray-500 dark:text-gray-400 text-center py-4"
                    id="no-files-message"
                >
                    {{ __('Select files to upload and provide details for each file') }}
                </p>
            </div>

            <div class="flex items-center justify-end">
                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    {{ __('Upload Documents') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('documents');
        if (fileInput) {
            fileInput.addEventListener('change', handleFileSelect);
        }
    });

    function handleFileSelect(event) {
        const fileInput = event.target;
        const previewContainer = document.getElementById('file-preview-container');
        const descriptionsContainer = document.getElementById('documentDescriptions');
        let noFilesMessage = document.getElementById('no-files-message');

        // 1) Clear out existing previews AND metadata inputs
        if (previewContainer) {
            previewContainer.innerHTML = '';
        }
        
        // Clear existing descriptions and reset no files message
        descriptionsContainer.innerHTML = `
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4" id="no-files-message">
                {{ __('Select files to upload and provide details for each file') }}
            </p>
        `;
        
        // Re-get the noFilesMessage element after resetting the container
        noFilesMessage = document.getElementById('no-files-message');

        // 2) If no files, show “select files” prompt and return
        if (!fileInput.files || fileInput.files.length === 0) {
            if (noFilesMessage) {
                noFilesMessage.style.display = 'block';
            }
            return;
        }
        if (noFilesMessage) {
            noFilesMessage.style.display = 'none';
        }

        // 3) For each chosen file: (a) show thumbnail if image, (b) build file_names[] & descriptions[]
        for (let i = 0; i < fileInput.files.length; i++) {
            const file = fileInput.files[i];

            // --- A) SHOW A PREVIEW, if it's an image ---
            if (file.type.startsWith('image/')) {
                // Create a wrapper div for the preview item
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item relative h-32 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden';
                previewItem.dataset.fileName = file.name;

                // Create the image preview
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                img.className = 'w-full h-full object-cover';

                // Create remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-btn';
                removeBtn.title = 'Remove file';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = (e) => {
                    e.stopPropagation();
                    removeFile(file.name);
                };

                previewItem.appendChild(img);
                previewItem.appendChild(removeBtn);
                previewContainer.appendChild(previewItem);

                // Once the image is loaded (or once the objectURL is set), revoke it to free memory
                img.onload = () => URL.revokeObjectURL(img.src);
            }
            // If you want a generic icon for non-images, you could add an else‐block here.

            // --- B) CREATE METADATA INPUTS FOR file_names[] and descriptions[] ---
            createFileInfoInputs(file, i, descriptionsContainer);
        }
    }

    function createFileInfoInputs(file, index, container) {
        const originalName = file.name.replace(/\.[^/.]+$/, '');
        const formattedDisplayName = originalName
            .replace(/[_-]/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .split(' ')
            .map(
                word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            )
            .join(' ');

        const wrapper = document.createElement('div');
        wrapper.className = 'bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 mb-4';

        wrapper.innerHTML = `
            <div class="flex items-start">
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">${file.name}</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024).toFixed(1)} KB</p>
                    <div class="mt-3 space-y-3">
                        <div>
                            <label for="file_name_${index}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('Display Name') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="file_names[]"
                                id="file_name_${index}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="${formattedDisplayName}"
                                placeholder="e.g., Event Map 2025"
                                required
                            >
                        </div>
                        <div>
                            <label for="description_${index}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('Description') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="descriptions[]"
                                id="description_${index}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="e.g., QR code for event check-in or Event map with parking zones"
                                required
                            >
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(wrapper);
    }

    function removeFile(fileName) {
        // Remove the preview item
        const previewItem = document.querySelector(`.preview-item[data-file-name="${fileName}"]`);
        if (previewItem) {
            previewItem.remove();
        }
        
        // Remove the file from the input
        const fileInput = document.getElementById('documents');
        const dataTransfer = new DataTransfer();
        const files = Array.from(fileInput.files).filter(file => file.name !== fileName);
        
        files.forEach(file => {
            dataTransfer.items.add(file);
        });
        
        fileInput.files = dataTransfer.files;
        
        // If no files left, show the no files message
        if (files.length === 0) {
            const noFilesMessage = document.getElementById('no-files-message');
            if (noFilesMessage) {
                noFilesMessage.style.display = 'block';
            }
            
            // Clear the descriptions container
            const descriptionsContainer = document.getElementById('documentDescriptions');
            if (descriptionsContainer) {
                descriptionsContainer.innerHTML = `
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4" id="no-files-message">
                        {{ __('Select files to upload and provide details for each file') }}
                    </p>
                `;
            }
        }
    }

    function validateForm() {
        const fileInput = document.getElementById('documents');
        const fileNames = document.querySelectorAll('input[name="file_names[]"]');
        const descriptions = document.querySelectorAll('input[name="descriptions[]"]');

        if (!fileInput.files || fileInput.files.length === 0) {
            alert('{{ __("Please select at least one file to upload.") }}');
            return false;
        }

        for (let i = 0; i < fileNames.length; i++) {
            if (!fileNames[i].value.trim()) {
                alert('{{ __("Please enter a display name for all files.") }}');
                fileNames[i].focus();
                return false;
            }
            if (!descriptions[i].value.trim()) {
                alert('{{ __("Please enter a description for all files.") }}');
                descriptions[i].focus();
                return false;
            }
        }
        return true;
    }
</script>