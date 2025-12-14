<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-900 via-indigo-800 to-black px-4">
        <div class="max-w-md w-full bg-gray-900 shadow-2xl rounded-xl p-8 text-white">

            <h2 class="text-center text-3xl font-bold mb-6">Apstipriniet e-pastu</h2>

            <p class="mb-4 text-gray-400 text-sm">
                Paldies par reģistrēšanos! Lūdzu, apstipriniet savu e-pasta adresi, noklikšķinot uz saites, ko mēs nosūtījām.
                Ja saite netika saņemta, mēs to nosūtīsim vēlreiz.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-green-400 text-sm">
                    Jauna apstiprinājuma saite tika nosūtīta uz jūsu e-pastu.
                </div>
            @endif

            <div class="flex flex-col gap-3 mt-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="w-full bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 px-6 py-2 rounded-lg mb-2">
                        Nosūtīt apstiprinājuma e-pastu vēlreiz
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full underline text-sm text-gray-400 hover:text-gray-300 rounded-lg py-2">
                        Iziet
                    </button>
                </form>

                <a href="{{ url('/') }}" class="mt-2 block text-center text-gray-400 hover:text-gray-300 text-sm">
                    Atpakaļ uz galveno
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
