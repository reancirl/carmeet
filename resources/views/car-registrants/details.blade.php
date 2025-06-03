<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Car Registration Details') }}
            </h2>
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            {{ $registration->carProfile->user->name }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                            {{ $registration->carProfile->year }} {{ $registration->carProfile->make }} {{ $registration->carProfile->model }}
                        </p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <dl>
                            <div class="bg-gray-50 dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $registration->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                        {{ $registration->status === 'denied' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                        {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                        {{ $registration->status === 'waitlist' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="bg-white dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $registration->is_paid ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $registration->is_paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </dd>
                            </div>
                            @if($registration->payment_note)
                            <div class="bg-gray-50 dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Note</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    {{ $registration->payment_note }}
                                </dd>
                            </div>
                            @endif
                            <div class="bg-white dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registration Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                    {{ $registration->created_at->format('M d, Y h:i A') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0">
                    <a href="{{ route('events.show', $registration->event) }}#registrants" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Back to Event
                    </a>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <a href="{{ route('car-registrants.edit-status', $registration) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Update Status
                        </a>
                        <a href="{{ route('car-registrants.edit-payment', $registration) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Update Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
