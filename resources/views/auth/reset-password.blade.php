<x-guest-layout>
    <div class="h-screen overflow-hidden flex items-center justify-center px-4
        bg-black bg-gradient-to-br from-purple-900/40 via-indigo-900/30 to-black">

        <div class="w-full max-w-md rounded-2xl p-8 text-white
            bg-gradient-to-b from-gray-900 to-black
            border border-purple-500/20
            shadow-[0_0_40px_rgba(168,85,247,0.25)]">

            <h2 class="text-center text-3xl font-bold mb-2
                tracking-widest
                text-purple-300
                drop-shadow-[0_0_12px_rgba(168,85,247,0.8)]">
                PASSWORD RESET
            </h2>

            <p class="mb-6 text-sm text-center text-gray-400">
                Ievadiet jauno paroli savam kontam.
            </p>

            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-900/50 text-red-400 rounded-lg text-sm">
                @foreach ($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    value="{{ old('email', $request->email) }}"
                    placeholder="E-pasts"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-gray-500 placeholder:text-gray-500
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Jaunā parole"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-gray-500 placeholder:text-gray-500
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Apstiprināt paroli"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-gray-500 placeholder:text-gray-500
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <button
                    type="submit"
                    class="w-full py-3 rounded-lg font-semibold tracking-wide
                    bg-purple-600 hover:bg-purple-500
                    shadow-[0_0_30px_rgba(168,85,247,0.6)]
                    hover:shadow-[0_0_45px_rgba(168,85,247,0.9)]
                    transition">
                    Atjaunot paroli
                </button>
            </form>

            <a href="{{ route('login') }}"
                class="block mt-6 text-center text-sm text-purple-400 hover:text-purple-300">
                Atpakaļ uz autorizāciju
            </a>

            <a href="{{ url('/') }}"
                class="block mt-4 text-center text-xs text-gray-500 hover:text-gray-300">
                Atpakaļ uz galveno
            </a>

        </div>
    </div>
</x-guest-layout>