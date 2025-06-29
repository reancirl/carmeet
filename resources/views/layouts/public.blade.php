<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name', 'CrateOS') }}{{ isset($title) ? ' | ' . $title : '' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
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
    <header class="bg-black/90 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center px-6 py-4">
            {{-- Logo --}}
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/crateos_logo.png') }}" alt="CrateOS" class="h-20">
            </a>

            {{-- Centered Search --}}
            <form action="{{ url('/') }}" method="GET" class="flex-1 mx-6">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search events"
                    class="w-full px-4 py-2 rounded-md text-black focus:outline-none" />
            </form>

            {{-- Auth Links --}}
            <div class="flex space-x-4">
                @auth
                    <a href="{{ auth()->user()->role === 'attendee' ? url('/event-registrations') : (auth()->user()->role === 'drivers' ? url('/event-registrations') : url('/events')) }}"
                        class="px-4 py-2 border rounded text-sm hover:bg-white/10">Home</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 border rounded text-sm hover:bg-white/10">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-red-500 text-white rounded text-sm hover:opacity-90">Sign Up</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="text-gray-400 py-6" style="background-color: #1f2129">
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
