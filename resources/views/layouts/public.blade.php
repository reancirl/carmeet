<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name', 'CrateOS') }}{{ isset($title) ? ' | ' . $title : '' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/crateos_logo.png') }}">
    <meta name="theme-color" content="#4f46e5">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
        </style>
    @endif
</head>

<body class="bg-[#0a0a0a] text-white flex flex-col min-h-screen">
    <!-- Announcement Banner -->
<div class="w-full bg-[#08062a] text-white">
  <div class="max-w-7xl mx-auto px-6 py-3">
    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6">
      <p class="flex-1 text-sm sm:text-base text-left mb-2 sm:mb-0">
        You’re early! Listings will appear here as organizers join the rollout. This is where the new wave of meets and shows will live—organized like a lineup.
      </p>
      <button
        type="button"
        class="inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded px-4 py-2 text-sm font-medium transition"
        aria-label="Copy invite link for hosts"
        onclick="
          navigator.clipboard.writeText(window.location.href)
            .then(() => alert('Link copied!'));
        "
      >
        Know a host who should be here? Send them this link
      </button>
    </div>
  </div>
</div>
    <header class="inset-x-0 top-0 z-50 bg-transparent">
    {{-- <header class="absolute inset-x-0 top-0 z-50 bg-transparent"> --}}
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <!-- Logo -->
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/crateos_logo_transparent.png') }}" alt="CrateOS" class="h-12 sm:h-20">
            </a>

            <!-- Hamburger (mobile only) -->
            <button id="menu-btn" class="sm:hidden focus:outline-none">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Nav & Search container -->
            <div id="mobile-menu" class="hidden sm:flex sm:items-center sm:space-x-6 flex-1 sm:mx-6">
                <!-- Search (hidden on xs) -->
                <form action="{{ url('/') }}" method="GET" class="hidden sm:flex flex-1">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Search events by Zipcode"
                        class="w-full px-4 py-2 rounded-md text-black focus:outline-none" />
                </form>

                <!-- Auth Links -->
                <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-4">
                    @auth
                        <a href="{{ auth()->user()->role === 'attendee' ? url('/event-registrations') : (auth()->user()->role === 'driver' ? url('/event-registrations') : url('/events')) }}"
                            class="px-4 py-2 border rounded text-sm hover:bg-white/10 text-center">
                            Home
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 border rounded text-sm hover:bg-white/10 text-center">
                            Log In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-red-500 text-white rounded text-sm hover:opacity-90 text-center">
                                Sign Up
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile menu panel -->
        <div id="mobile-panel" class="hidden bg-[#0a0a0a] text-white">
            <form action="{{ url('/') }}" method="GET" class="px-6 py-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search events by Zipcode"
                    class="w-full px-4 py-2 rounded-md text-black focus:outline-none" />
            </form>
            <div class="flex flex-col px-6 pb-4 space-y-2">
                @auth
                    <a href="{{ auth()->user()->role === 'attendee' ? url('/event-registrations') : (auth()->user()->role === 'driver' ? url('/event-registrations') : url('/events')) }}"
                        class="block px-4 py-2 border rounded text-sm hover:bg-white/10 text-center">
                        Home
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="block px-4 py-2 border rounded text-sm hover:bg-white/10 text-center">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="block px-4 py-2 bg-red-500 text-white rounded text-sm hover:opacity-90 text-center">
                            Sign Up
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <script>
            const btn = document.getElementById('menu-btn');
            const panel = document.getElementById('mobile-panel');
            btn.addEventListener('click', () => panel.classList.toggle('hidden'));
        </script>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="text-gray-400 py-6 bg-top bg-cover"
        style="background-image: url('{{ asset('images/hero-background-inverted.png') }}')">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-center gap-6 text-sm">
            <a href="#" class="hover:underline">About CrateOS</a>
            <a href="#" class="hover:underline">How it Works</a>
            <a href="#" class="hover:underline">Careers</a>
            <a href="#" class="hover:underline">Press/Media</a>
            <a href="#" class="hover:underline">Terms of Use</a>
            <a href="#" class="hover:underline">Privacy Policy</a>
            <a href="#" class="hover:underline">Help / FAQ</a>
            <a href="#" class="hover:underline">Contact Us</a>
        </div>
        {{-- flex space between --}}
        <div
            class="flex flex-col items-center space-y-2 px-2 pt-4
         sm:flex-row sm:justify-between sm:space-y-0 sm:px-6">
            <p class="text-center text-xs text-gray-600">
                ©2025 CrateOS. All rights reserved.
            </p>

            <a href="https://importcrate.com/" target="_blank" class="text-center text-xs text-gray-600 underline">
                Shop Import Crate
            </a>

            <p class="text-center text-xs text-gray-600">
                Powered by Import Crate
            </p>
        </div>
    </footer>
</body>

</html>
