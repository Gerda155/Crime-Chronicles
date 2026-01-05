<x-guest-layout>
    <div class="h-screen overflow-hidden flex items-center justify-center px-4
    bg-black bg-gradient-to-br from-purple-900/40 via-indigo-900/30 to-black">


        <div class="w-full max-w-3xl rounded-2xl p-8 text-white
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
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Левая колонка -->
                    <div class="flex-1 flex flex-col gap-4">
                        <!-- Имя -->
                        <input name="name" required placeholder="Vārds" value="{{ old('name') }}"
                            class="px-4 py-2 rounded-lg bg-gray-950 text-gray-900 border border-gray-700
                       focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 outline-none transition">
                        @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror

                        <!-- Почта и юзернейм -->
                        <div class="flex gap-4">
                            <div class="flex-1 flex flex-col">
                                <input name="email" type="email" required placeholder="E-pasts" value="{{ old('email') }}"
                                    class="px-4 py-2 rounded-lg bg-gray-950 text-gray-900 border border-gray-700
                               focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 outline-none transition">
                                @error('email')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 flex flex-col">
                                <input name="username" required placeholder="Segvārds" value="{{ old('username') }}"
                                    class="px-4 py-2 rounded-lg bg-gray-950 text-gray-900 border border-gray-700
                               focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 outline-none transition">
                                @error('username')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Био -->
                        <textarea name="bio" placeholder="Par mani" rows="3"
                            class="w-full px-4 py-2 rounded-lg bg-gray-950 text-gray-900 placeholder:text-gray-500 border border-gray-700
                       focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 outline-none transition">{{ old('bio') }}</textarea>
                        @error('bio')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror

                        <!-- Пароли -->
                        <div class="flex gap-4">
                            <div class="flex-1 flex flex-col">
                                <input name="password" type="password" required placeholder="Parole"
                                    class="px-4 py-2 rounded-lg bg-gray-950 text-gray-900 border border-gray-700
                               focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 outline-none transition">
                                @error('password')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 flex flex-col">
                                <input name="password_confirmation" type="password" required placeholder="Apstiprināt paroli"
                                    class="px-4 py-2 rounded-lg bg-gray-950 text-gray-900 border border-gray-700
                               focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 outline-none transition">
                            </div>
                        </div>
                    </div>

                    <!-- Правая колонка (аватар) -->
                    <div class="w-64 flex flex-col items-center">
                        <label for="avatarInput" class="form-label mb-2">Izvēlies avatāru</label>
                        <input type="file" id="avatarInput" accept="image/*">
                        <div class="mt-4 w-64 h-64 border border-gray-600">
                            <img id="avatarPreview" class="w-full h-full object-contain">
                        </div>
                        <input type="hidden" name="avatar_cropped" id="avatarCropped">
                        @error('avatar')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="mt-6 w-full py-3 rounded-lg font-semibold tracking-wide
               bg-gradient-to-r from-pink-500 to-indigo-500 shadow-[0_0_30px_rgba(168,85,247,0.6)]
               hover:shadow-[0_0_45px_rgba(168,85,247,0.9)] transition">
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

    <script>
        let cropper;
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarCropped = document.getElementById('avatarCropped');

        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function() {
                avatarPreview.src = reader.result;

                if (cropper) cropper.destroy();

                cropper = new Cropper(avatarPreview, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                });
            };
            reader.readAsDataURL(file);
        });

        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 250,
                    height: 250,
                });
                avatarCropped.value = canvas.toDataURL('image/jpeg');
            }
        });
    </script>
</x-guest-layout>