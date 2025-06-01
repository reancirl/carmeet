@props(['event'])

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Car Registrations</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage all car registrations for this event
                </p>
            </div>
        </div>
        
        @if($event->registrations->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No registrations yet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Get started by sharing the event link with potential participants.
                </p>
                <div class="mt-6">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Share Event
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Registrant') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Car') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Payment') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse($event->registrations as $registration)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $registration->carProfile->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-200">
                                            {{ $registration->carProfile->year }} {{ $registration->carProfile->make }} {{ $registration->carProfile->model }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('registrations.update-status-form', $registration) }}" class="status-form">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="status-select form-select rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 text-sm" data-registration-id="{{ $registration->id }}">
                                                <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                                <option value="approved" {{ $registration->status == 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                                <option value="denied" {{ $registration->status == 'denied' ? 'selected' : '' }}>{{ __('Denied') }}</option>
                                                <option value="waitlist" {{ $registration->status == 'waitlist' ? 'selected' : '' }}>{{ __('Waitlist') }}</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('registrations.update-payment-form', $registration) }}" class="payment-form flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center">
                                                <input type="checkbox" name="is_paid" id="paid-{{ $registration->id }}" class="paid-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900" {{ $registration->is_paid ? 'checked' : '' }} data-registration-id="{{ $registration->id }}">
                                                <label for="paid-{{ $registration->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Paid') }}</label>
                                            </div>
                                        </form>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate max-w-[150px]" title="{{ $registration->payment_note }}">{{ $registration->payment_note }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 dark:text-blue-500 hover:underline view-details" data-registration-id="{{ $registration->id }}">{{ __('View Details') }}</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('No car registrations yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
</div>

<!-- Registration Review Modal -->
<div id="registration-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modal-title">{{ __('Car Registration Details') }}</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="close-modal">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div id="modal-content" class="space-y-6">
                <!-- Content will be loaded via JavaScript -->
            </div>
            
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4 space-y-4">
                <h4 class="font-medium text-gray-900 dark:text-white">{{ __('Actions') }}</h4>
                <div class="flex flex-wrap gap-2">
                    <button type="button" id="approve-btn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">{{ __('Approve') }}</button>
                    <button type="button" id="deny-btn" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">{{ __('Deny') }}</button>
                    <button type="button" id="waitlist-btn" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">{{ __('Waitlist') }}</button>
                </div>
                
                <div class="mt-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="modal-paid" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900">
                        <label for="modal-paid" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Mark as Paid') }}</label>
                    </div>
                    
                    <div class="mt-3">
                        <label for="payment-note" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Payment Note') }}</label>
                        <textarea id="payment-note" rows="2" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600"></textarea>
                    </div>
                    
                    <button type="button" id="save-payment" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">{{ __('Save Payment Info') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
