<x-public-layout>
    {{-- Hero Spotlight Carousel --}}
    <section id="heroCarousel" class="relative bg-center bg-cover h-96 md:h-[500px]"
        style="background-image: url('{{ asset('images/herobackground.jpg') }}')">
        {{-- Dark overlay --}}
        <div class="absolute inset-0 bg-black/50"></div>

        <div
            class="relative max-w-7xl mx-auto flex flex-col lg:flex-row items-center h-full
           px-4 sm:px-6 lg:px-12 py-6 space-y-6 lg:space-y-0 lg:space-x-8">
            {{-- Poster card (smaller on mobile) --}}
            <div class="w-40 sm:w-48 md:w-56 lg:w-72 flex-shrink-0">
                <a href="{{ route('public.events.show', $featuredEvent) }}">
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                        @if (!empty($featuredEvent->flyer_url))
                            <img src="{{ $featuredEvent->flyer_url }}" alt="{{ $featuredEvent->name }} flyer"
                                class="w-full object-cover">
                        @endif
                        <img src="{{ $featuredEvent->image_url }}" alt="{{ $featuredEvent->name }}"
                            class="w-full object-cover">
                    </div>
                </a>
            </div>

            {{-- Event details --}}
            <div class="w-full lg:flex-1 text-center lg:text-left space-y-2">
                <p class="uppercase text-xs sm:text-sm text-gray-300">Ultimate Garage Events</p>
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-5xl font-bold leading-tight">
                    {{ $featuredEvent->name }}
                </h1>

                @php
                    $firstDay = $featuredEvent->is_multi_day ? $featuredEvent->days->first() : null;
                    $lastDay = $featuredEvent->is_multi_day ? $featuredEvent->days->last() : null;
                @endphp

                {{-- Date --}}
                <p class="text-sm sm:text-base">
                    @if ($featuredEvent->is_multi_day && $firstDay && $lastDay)
                        {{ \Carbon\Carbon::parse($firstDay->date)->format('M j') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($lastDay->date)->format('j, Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($featuredEvent->date)->format('M j, Y') }}
                    @endif
                </p>

                {{-- Time --}}
                <p class="text-sm sm:text-base">
                    @if ($featuredEvent->is_multi_day && $firstDay)
                        {{ \Carbon\Carbon::parse($firstDay->start_time)->format('g:i A') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($firstDay->end_time)->format('g:i A') }}
                    @else
                        {{ \Carbon\Carbon::parse($featuredEvent->start_time)->format('g:i A') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($featuredEvent->end_time)->format('g:i A') }}
                    @endif
                </p>

                {{-- Location --}}
                <div class="flex justify-center lg:justify-start items-start space-x-2 text-sm sm:text-base">
                    <div>
                        <p class="text-gray-300">
                            {{ $featuredEvent->city }}, {{ $featuredEvent->state }} {{ $featuredEvent->zip_code }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('public.events.show', $featuredEvent) }}"
                    class="inline-block mt-4 px-4 sm:px-6 py-2 sm:py-3 bg-yellow-500 text-black rounded-md
               text-sm sm:text-base hover:bg-yellow-600 transition">
                    View Details
                </a>

                <p class="pt-4 text-xs sm:text-sm text-gray-300 uppercase">
                    NOTE: THIS IS THE PREMIER SPOTLIGHT OR MAINSTAGE<br>
                    THIS IS A CAROUSEL WITH UP TO MAX OF 10 EVENTS
                </p>
            </div>
        </div>
    </section>

    @php
        function renderEventGrid($events)
        {
            echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">';
            foreach ($events as $event) {
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
                  <a href="{$event->url}">
                    <img
                      src="{$event->image_url}"
                      alt="{$event->name}"
                      class="w-full rounded-md shadow-lg object-cover h-48 sm:h-56"
                    >
                  </a>
                  <div class="space-y-1 px-1 sm:px-0">
                    <h3 class="text-lg sm:text-xl font-bold text-white truncate">
                      <a href="{$event->url}" class="hover:underline">{$event->name}</a>
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
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-12">
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
