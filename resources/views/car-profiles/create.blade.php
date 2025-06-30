<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Car') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Global Errors --}}
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('car-profiles.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Year -->
                            <div>
                                <label for="year"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Year') }}
                                </label>
                                <input type="number" name="year" id="year" value="{{ old('year') }}"
                                    min="1900" max="{{ date('Y') + 1 }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('year') border-red-500 @enderror"
                                    required>
                                @error('year')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Make -->
                            <div>
                                <label for="make"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Make') }}
                                </label>
                                <input type="text" name="make" id="make" value="{{ old('make') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('make') border-red-500 @enderror"
                                    required autofocus>
                                @error('make')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Model -->
                            <div>
                                <label for="model"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Model') }}
                                </label>
                                <input type="text" name="model" id="model" value="{{ old('model') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('model') border-red-500 @enderror"
                                    required>
                                @error('model')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Trim -->
                            <div>
                                <label for="trim"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Trim (Optional)') }}
                                </label>
                                <input type="text" name="trim" id="trim" value="{{ old('trim') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('trim') border-red-500 @enderror">
                                @error('trim')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Color -->
                            <div>
                                <label for="color"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Color') }}
                                </label>
                                <input type="text" name="color" id="color" value="{{ old('color') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('color') border-red-500 @enderror">
                                @error('color')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Plate Number -->
                            <div>
                                <label for="plate"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Plate Number') }}
                                </label>
                                <input type="text" name="plate" id="plate" value="{{ old('plate') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                           @error('plate') border-red-500 @enderror">
                                @error('plate')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Mods -->
                        <div class="md:col-span-2">
                            <label for="mods" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Modifications') }}
                            </label>
                            <textarea id="mods" name="mods" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                       @error('mods') border-red-500 @enderror">{{ old('mods') }}</textarea>
                            @error('mods')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Description (Optional)') }}
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                       @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Social Media Links Section -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                {{ __('Social Media Links') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Facebook -->
                                <div>
                                    <label for="facebook"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Facebook (Optional)') }}
                                    </label>
                                    <input type="text" name="facebook" id="facebook" value="{{ old('facebook') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                        focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                        @error('facebook') border-red-500 @enderror">
                                    @error('facebook')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Instagram -->
                                <div>
                                    <label for="instagram"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Instagram') }}
                                    </label>
                                    <input type="text" name="instagram" id="instagram" required
                                        value="{{ old('instagram') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                        focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                        @error('instagram') border-red-500 @enderror">
                                    @error('instagram')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- TikTok -->
                                <div>
                                    <label for="tiktok"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('TikTok (Optional)') }}
                                    </label>
                                    <input type="text" name="tiktok" id="tiktok" value="{{ old('tiktok') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                        focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                        @error('tiktok') border-red-500 @enderror">
                                    @error('tiktok')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- X -->
                                <div>
                                    <label for="x"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Twitter (Optional) ') }}
                                    </label>
                                    <input type="text" name="x" id="x" value="{{ old('x') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                                        focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                                        @error('x') border-red-500 @enderror">
                                    @error('x')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Mod Tags with hint -->
                        <div class="md:col-span-2">
                            <label for="mod_tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Mod Tags') }}
                            </label>
                            <input type="text" name="mod_tags" id="mod_tags" value="{{ old('mod_tags') }}" required
                                placeholder="e.g. air suspension, widebody, wrap"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300
                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm
                            @error('mod_tags') border-red-500 @enderror">
                            <p class="text-xs text-gray-400 mt-1">Separate multiple tags with commas</p>
                            @error('mod_tags')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Car Images -->
                        <div class="md:col-span-2">
                            <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Car Images') }} <span class="text-xs text-gray-500">(You can upload multiple
                                    images</span>
                                <span class="text-xs text-gray-500"> - JPG, JPEG, PNG. Max size: 5MB.)</span>
                            </label>
                            <div id="image-preview-container" class="mt-2">
                                <div id="image-preview" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                </div>
                            </div>
                            <input type="file" name="images[]" id="images" multiple accept="image/*"
                                onchange="previewImages(event)"
                                class="mt-3 block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                                       file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                       @error('images.*') border-red-500 @enderror">
                            @error('images.*')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-end md:col-span-2">
                            <a href="{{ route('car-profiles.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-300 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                {{ __('Add Car') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        function previewImages(event) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = ''; // Clear existing previews

            const files = event.target.files;

            if (files) {
                Array.from(files).forEach(file => {
                    if (!file.type.match('image.*')) {
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'h-32 w-full object-cover rounded';
                        div.appendChild(img);

                        preview.appendChild(div);
                    };

                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</x-app-layout>
