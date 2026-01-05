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
                CRIME CHRONICLES
            </h2>

            <p class="text-center text-sm text-gray-400 mb-6">
                Izveido savu detektīva profilu
            </p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <input name="name" required placeholder="Vārds"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-white
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <input name="username" required placeholder="Segvārds"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-white
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <input name="email" type="email" required placeholder="E-pasts"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-white
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <input name="password" type="password" required placeholder="Parole"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-white
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <input name="password_confirmation" type="password" required placeholder="Apstiprināt paroli"
                    class="w-full px-4 py-2 rounded-lg
                    bg-gray-950 text-white
                    border border-gray-700
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30
                    outline-none transition">

                <button
                    class="w-full py-3 rounded-lg font-semibold tracking-wide
                    bg-gradient-to-r from-pink-500 to-indigo-500
                    shadow-[0_0_30px_rgba(168,85,247,0.6)]
                    hover:shadow-[0_0_45px_rgba(168,85,247,0.9)]
                    transition">
                    Reģistrēties
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-400">
                Jau ir konts?
                <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300">
                    Pieteikties
                </a>
            </p>

            <a href="{{ url('/') }}" class="block mt-4 text-center text-xs text-gray-500 hover:text-gray-300">
                Atpakaļ uz galveno
            </a>
        </div>
    </div>
</x-guest-layout>