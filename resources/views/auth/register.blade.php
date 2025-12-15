<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-900 via-indigo-800 to-black px-4">
        <div class="max-w-md w-full bg-gray-900 shadow-2xl rounded-xl p-8 text-white">

            <h2 class="text-center text-3xl font-bold mb-6">Reģistrēties</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="name" :value="__('Vārds')" />
                    <x-text-input
                        id="name"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="username" :value="__('Segvārds')" />
                    <x-text-input
                        id="username"
                        type="text"
                        name="username"
                        :value="old('username')"
                        required
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="email" :value="__('E-pasts')" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Parole')" />
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Apstiprināt paroli')" />
                    <x-text-input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />
                </div>

                <x-primary-button>Reģistrēties</x-primary-button>
            </form>


            @if ($errors->any())
            <div class="mt-4 text-red-400 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <a href="{{ url('/') }}" class="mt-4 block text-center text-gray-400 hover:text-gray-300 text-sm">
                Atpakaļ uz galveno
            </a>

        </div>
    </div>
</x-guest-layout>