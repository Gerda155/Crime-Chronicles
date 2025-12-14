<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-900 via-indigo-800 to-black px-4">
        <div class="max-w-md w-full bg-gray-900 shadow-2xl rounded-xl p-8 text-white">

            <h2 class="text-center text-3xl font-bold mb-6">Apstipriniet paroli</h2>

            <p class="mb-4 text-gray-400 text-sm">
                Šī ir droša lietotnes zona. Lūdzu, apstipriniet savu paroli, lai turpinātu.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Parole -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Parole')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 px-6 py-2 rounded-lg">
                        Apstiprināt
                    </x-primary-button>
                </div>
            </form>

            <a href="{{ url('/') }}" class="mt-4 block text-center text-gray-400 hover:text-gray-300 text-sm">
                Atpakaļ uz galveno
            </a>

        </div>
    </div>
</x-guest-layout>
