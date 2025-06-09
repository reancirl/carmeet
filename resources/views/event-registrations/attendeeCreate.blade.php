<x-public-layout :title="'Register as Attendee for ' . $event->name">
    <div class="max-w-xl mx-auto mt-10">
        <form method="POST" action="{{ route('event-attendee-registrations.store', $event) }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Event</label>
                <input type="text" value="{{ $event->name }}" class="mt-1 block w-full" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Attendee</label>
                <input type="text" value="{{ Auth::user()->name }}" class="mt-1 block w-full" disabled>
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Register
            </button>
        </form>
    </div>
</x-public-layout>