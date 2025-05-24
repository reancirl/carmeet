<x-public-layout>
    {{-- Search Filter --}}
    <div>
        <form method="GET" action="{{ url('/') }}"
              class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
            <input
                type="text"
                name="zip_code"
                value="{{ request('zip_code') }}"
                placeholder="Enter ZIP code"
                class="w-full sm:flex-1 border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              />
              <button
                type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
              >Search</button>
            </form>
          </div>

          {{-- Event List --}}
          @forelse($events as $event)
            <article class="flex flex-col md:flex-row items-start space-y-4 md:space-y-0 md:space-x-6">
              @if($event->image_url)
                <a href="{{ route('public.events.show', $event) }}">
                  <img
                    src="{{ $event->image_url }}"
                    alt="{{ $event->name }}"
                    class="w-full md:w-48 h-auto md:h-48 object-cover rounded-md flex-shrink-0"
                  >
                </a>
              @endif

              <div class="flex-1">
                <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-1">
                  <a href="{{ route('public.events.show', $event) }}" class="underline hover:no-underline">
                    {{ $event->name }}
                  </a>
                </h2>

                <p class="text-sm text-[#62605b] dark:text-[#a1a09a] mb-2">
                  Organizer: {{ $event->organizer->name }}
                </p>

                <p class="text-sm text-[#62605b] dark:text-[#a1a09a]">
                  <time>
                    {{ date('m/d/Y (D), ', strtotime($event->date)) }} {{ date('g:i A', strtotime($event->start_time)) }} - {{ date('g:i A', strtotime($event->end_time)) }}
                  </time><br>
                  {{ $event->location_name }} - {{ $event->street }}, {{ $event->city }}, {{ $event->state }}, {{ $event->zip_code }}
                </p>

                <a
                  href="{{ route('public.events.show', $event) }}"
                  class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                >View More</a>
              </div>
            </article>
          @empty
            <p class="text-center text-gray-600 dark:text-gray-400">
              No events found for “{{ request('zip_code') }}”
            </p>
          @endforelse

</x-public-layout>
