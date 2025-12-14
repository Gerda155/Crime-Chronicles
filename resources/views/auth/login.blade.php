<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-900 via-indigo-800 to-black px-4">
        <div class="max-w-md w-full bg-gray-900 shadow-2xl rounded-xl p-8 text-white">

            <h2 class="text-center text-3xl font-bold mb-6">Pieteikties</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- E-pasts -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('E-pasts')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Parole -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Parole')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Atcerēties mani -->
                <div class="flex items-center mb-4">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-600 bg-gray-800 text-indigo-600 focus:ring-indigo-500" name="remember">
                    <label for="remember_me" class="ml-2 text-gray-300 text-sm">Atcerēties mani</label>
                </div>

                <!-- Poga un saite -->
                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-400 hover:text-indigo-300" href="{{ route('password.request') }}">
                            Aizmirsi paroli?
                        </a>
                    @endif

                    <x-primary-button class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 px-6 py-2 rounded-lg">
                        Pieteikties
                    </x-primary-button>
                </div>
            </form>

            <p class="mt-6 text-center text-gray-400 text-sm">
                Nav konta? 
                <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold">Reģistrējies šeit</a>
            </p>

            <a href="{{ url('/') }}" class="mt-4 block text-center text-gray-400 hover:text-gray-300 text-sm">
                Atpakaļ uz galveno
            </a>

        </div>
    </div>
</x-guest-layout>
