<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Update Payment Information') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $registration->carProfile->user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $registration->carProfile->year }} {{ $registration->carProfile->make }} {{ $registration->carProfile->model }}
                            </p>
                        </div>

                        <form action="{{ route('car-registrants.update-payment', $registration) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <input type="checkbox" id="is_paid" name="is_paid" value="1" 
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-700 rounded dark:bg-gray-900"
                                        {{ $registration->is_paid ? 'checked' : '' }}>
                                    <label for="is_paid" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Mark as Paid') }}
                                    </label>
                                </div>
                                @error('is_paid')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="payment_note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Payment Note') }}
                                </label>
                                <textarea id="payment_note" name="payment_note" rows="3" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('payment_note', $registration->payment_note) }}</textarea>
                                @error('payment_note')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('car-registrants.details', $registration) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ __('Update Payment') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
