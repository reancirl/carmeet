<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Events') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

   @if(auth()->user()->role == 'admin')
        <div class="mt-12">
            <button
            id="toggle-users-btn"
            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            type="button"
            >
            Show Registered Users
            </button>

            <div id="users-list" class="hidden overflow-x-auto rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">🛠️ List of All Registered Users</h2>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Email') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Role') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">

                </tbody>
            </table>
            </div>
        </div>
    @endif

      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <div class="flex justify-between items-center mb-6">
            <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              {{ __('Create New Event') }}
            </a>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Name') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Date & Time') }}</th>
                  @if(auth()->user()->role == 'admin')
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Organizer') }}</th>
                  @endif
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Car Registrants') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Attendees') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($events as $event)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      @if($event->is_multi_day)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mr-2">Multi-day</span>
                        <div>
                          @foreach($event->days as $day)
                            <div class="text-sm">{{ date('m/d/Y (D)', strtotime($day->date)) }}: {{ date('g:i A', strtotime($day->start_time)) }} - {{ date('g:i A', strtotime($day->end_time)) }}</div>
                          @endforeach
                        </div>
                      @else
                        {{ date('m/d/Y (D)', strtotime($event->date)) }}, {{ date('g:i A', strtotime($event->start_time)) }} - {{ date('g:i A', strtotime($event->end_time)) }}
                      @endif
                    </td>
                    @if(auth()->user()->role == 'admin')
                      <td class="px-6 py-4 whitespace-nowrap">{{ $event->organizer->name }}</td>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->registrations->count() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->attendees->count() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-900 mr-2">{{ __('View') }}</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</x-app-layout>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('toggle-users-btn');
    const usersList = document.getElementById('users-list');

    btn.addEventListener('click', () => {
      if (usersList.classList.contains('hidden')) {
        usersList.classList.remove('hidden');
        btn.textContent = 'Hide Registered Users';
      } else {
        usersList.classList.add('hidden');
        btn.textContent = 'Show Registered Users';
      }
    });
  });
</script>
