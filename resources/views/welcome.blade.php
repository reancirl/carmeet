<x-public-layout>
    {{-- Hero Spotlight Carousel --}}
    <section id="heroCarousel" class="relative bg-bottom bg-cover pt-14 sm:pt-24"
        style="background-image: url('{{ asset('images/hero-background.png') }}')" x-data="{
            index: 0,
            total: {{ $featuredEvents->count() }},
            prev() { this.index = this.index === 0 ? this.total - 1 : this.index - 1 },
            next() { this.index = this.index === this.total - 1 ? 0 : this.index + 1 }
        }">
        @if ($featuredEvents->isNotEmpty())
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-6">

                {{-- Slides wrapper --}}
                <div class="flex justify-start pl-0 sm:pl-5">
                    @foreach ($featuredEvents as $i => $featuredEvent)
                        <div x-show="index === {{ $i }}" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-x-full"
                            x-transition:enter-end="opacity-100 transform translate-x-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform translate-x-0"
                            x-transition:leave-end="opacity-0 transform -translate-x-full"
                            class="flex-shrink-0 w-full flex flex-col lg:flex-row items-center space-y-6 lg:space-y-0 lg:space-x-8"
                            style="display: none;">
                            {{-- Poster card --}}
                            <div class="w-full sm:w-2/3 md:w-1/2 lg:w-72 flex-shrink-0 pl-3">
                                <a href="{{ route('public.events.show', $featuredEvent->slug) }}">
                                    <div class="bg-white rounded-lg overflow-hidden shadow-lg h-72 sm:h-80">
                                        @if ($featuredEvent->flyer_url)
                                            <img src="{{ $featuredEvent->flyer_url }}"
                                                alt="{{ $featuredEvent->name }} flyer"
                                                class="w-full h-full object-cover">
                                        @endif
                                        <img src="{{ $featuredEvent->image_url }}" alt="{{ $featuredEvent->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                </a>
                            </div>

                            {{-- Event details --}}
                            <div class="w-full lg:flex-1 text-center lg:text-left space-y-2">
                                <p class="uppercase text-xs sm:text-sm text-gray-300">Ultimate Garage Events</p>
                                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold leading-tight">
                                    {{ $featuredEvent->name }}
                                </h1>

                                @php
                                    $firstDay = $featuredEvent->is_multi_day ? $featuredEvent->days->first() : null;
                                    $lastDay = $featuredEvent->is_multi_day ? $featuredEvent->days->last() : null;
                                @endphp

                                {{-- Date --}}
                                <p class="text-sm sm:text-base">
                                    @if ($featuredEvent->is_multi_day && $firstDay && $lastDay)
                                        {{ \Carbon\Carbon::parse($firstDay->date)->format('M j') }} &ndash;
                                        {{ \Carbon\Carbon::parse($lastDay->date)->format('j, Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($featuredEvent->date)->format('M j, Y') }}
                                    @endif
                                </p>

                                {{-- Time --}}
                                <p class="text-sm sm:text-base">
                                    @if ($featuredEvent->is_multi_day && $firstDay)
                                        {{ \Carbon\Carbon::parse($firstDay->start_time)->format('g:i A') }} &ndash;
                                        {{ \Carbon\Carbon::parse($firstDay->end_time)->format('g:i A') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($featuredEvent->start_time)->format('g:i A') }}
                                        &ndash;
                                        {{ \Carbon\Carbon::parse($featuredEvent->end_time)->format('g:i A') }}
                                    @endif
                                </p>

                                {{-- Location --}}
                                <p class="text-sm sm:text-base text-gray-300">
                                    {{ $featuredEvent->city }}, {{ $featuredEvent->state }}
                                    {{ $featuredEvent->zip_code }}
                                </p>

                                <a href="{{ route('public.events.show', $featuredEvent->slug) }}"
                                    class="inline-block mt-4 px-6 py-3 bg-yellow-500 text-black rounded-md text-base hover:bg-yellow-600 transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Prev button --}}
                <button @click="prev()"
                    class="absolute left-2 sm:left-6 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 hover:bg-opacity-75 text-white p-2 sm:p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Next button --}}
                <button @click="next()"
                    class="absolute right-2 sm:right-6 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 hover:bg-opacity-75 text-white p-2 sm:p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        @endif
    </section>

    @php
        function renderEventGrid($events)
        {
            if ($events->isEmpty()) {
                echo '<p class="text-center text-gray-400 py-8">No events found.</p>';
                return;
            }

            echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">';
            foreach ($events as $event) {
                $url = route('public.events.show', ['event' => $event->slug]);
                $organizer = $event->organizer->name ?? 'Ultimate Garage Events';
                if ($event->is_multi_day && $event->days->count() > 1) {
                    $first = \Carbon\Carbon::parse($event->days->first()->date);
                    $last = \Carbon\Carbon::parse($event->days->last()->date);
                    $dateText = $first->format('M j') . ' – ' . $last->format('j, Y');
                } else {
                    $dateText = \Carbon\Carbon::parse($event->date)->format('M j, Y');
                }

                echo <<<HTML
                <div class="space-y-2">
                  <a href="{$url}">
                    <img
                      src="{$event->image_url}"
                      alt="{$event->name}"
                      class="w-full rounded-md shadow-lg object-cover h-48 sm:h-32"
                    >
                  </a>
                  <div class="space-y-1 px-1 sm:px-0">
                    <h3 class="text-lg sm:text-xl font-bold text-white truncate">
                      <a href="{$url}" class="hover:underline">{$event->name}</a>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-300 truncate">{$organizer}</p>
                    <p class="text-xs sm:text-sm text-white">{$dateText}</p>
                  </div>
                </div>
                HTML;
            }
            echo '</div>';
        }
    @endphp

    {{-- Happening This Weekend --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-12 pt-32 sm:pt-16">
        <h2 class="text-2xl sm:text-3xl text-yellow-500 font-semibold mb-6">
            Happening This Weekend
        </h2>
        {!! renderEventGrid($weekendEvents) !!}
    </section>

    {{-- Events Near You --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <h2 class="text-2xl sm:text-3xl text-yellow-500 font-semibold mb-6">Events Near You</h2>
        {!! renderEventGrid($nearbyEvents) !!}
    </section>

    {{-- Upcoming Events --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <h2 class="text-2xl sm:text-3xl text-yellow-500 font-semibold mb-6">Upcoming Events</h2>
        {!! renderEventGrid($upcomingEvents) !!}
    </section>
</x-public-layout>
