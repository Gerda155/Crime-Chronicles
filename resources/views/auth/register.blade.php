<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-900 via-indigo-800 to-black px-4">
        <div class="max-w-md w-full bg-gray-900 shadow-2xl rounded-xl p-8 text-white">

            <h2 class="text-center text-3xl font-bold mb-6">Reģistrēties</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Vārds -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Vārds')" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- E-pasts -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('E-pasts')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Parole -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Parole')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Apstiprināt paroli -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Apstiprināt paroli')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('login') }}" class="underline text-sm text-gray-400 hover:text-gray-300">
                        Jau ir konts?
                    </a>

                    <x-primary-button class="ml-3 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 px-6 py-2 rounded-lg">
                        Reģistrēties
                    </x-primary-button>
                </div>
            </form>

            <a href="{{ url('/') }}" class="mt-4 block text-center text-gray-400 hover:text-gray-300 text-sm">
                Atpakaļ uz galveno
            </a>

        </div>
    </div>
</x-guest-layout>
