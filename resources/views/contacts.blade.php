<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    @include('partials.header')
    @include('partials.burger')

    <main class="min-vh-10 d-flex justify-content-center align-items-center text-light">
        <div class="w-100" style="max-width: 480px;">

            <div class="mb-4 text-center">
                <h1 class="mb-3 text-purple-300">Kontakti</h1>

                <p class="mb-1"><strong>Tālrunis:</strong> +371 2X XXX XXX</p>
                <p><strong>E-pasts:</strong> crimechronicles45@gmail.com</p>
            </div>

            @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <div class="p-4 rounded-4 bg-dark border border-purple-500/25 shadow-lg">
                <form method="POST" action="{{ route('contacts.send') }}">
                    @csrf

                    <div class="mb-3 text-start">
                        <label class="form-label">Vārds</label>
                        <input type="text" name="name" class="form-control bg-black text-light border-secondary" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label">E-pasts</label>
                        <input type="email" name="email" class="form-control bg-black text-light border-secondary" required>
                    </div>

                    <div class="mb-4 text-start">
                        <label class="form-label">Ziņa</label>
                        <textarea name="message" rows="4"
                            class="form-control bg-black text-light border-secondary"
                            required></textarea>
                    </div>

                    <div class="d-grid gap-3">
                        <button
                            type="submit" class="py-3 rounded-lg fw-semibold tracking-wide
                        bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500
                        shadow-[0_0_30px_rgba(168,85,247,0.6)]
                        hover:shadow-[0_0_45px_rgba(168,85,247,0.9)]
                        transition border-0 text-white">
                            Nosūtīt ziņu
                        </button>

                        <a href="{{ url()->previous() }}"
                            class="py-2 rounded-lg text-center text-decoration-none
                        bg-gradient-to-r from-gray-700 to-gray-900
                        text-light hover:opacity-90 transition">
                            Atpakaļ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>