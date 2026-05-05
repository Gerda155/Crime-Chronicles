<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Jauna lieta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">
            Jaunas lietas izveide
        </h1>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card bg-secondary text-light border-0 shadow rounded">

                    <div class="card-body p-4">

                        <form method="POST" action="{{ route('user.cases.store') }}">
                            @csrf

                            {{-- TITLE --}}
                            <div class="mb-3">
                                <label class="form-label">Nosaukums</label>
                                <input type="text"
                                    name="title"
                                    class="form-control bg-dark text-light border-0 rounded"
                                    placeholder="Ievadi lietas nosaukumu"
                                    required>
                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="mb-3">
                                <label class="form-label">Apraksts</label>
                                <textarea name="description"
                                    rows="4"
                                    class="form-control bg-dark text-light border-0 rounded"
                                    placeholder="Apraksti lietu..."
                                    required></textarea>
                            </div>

                            {{-- GENRE --}}
                            <div class="mb-3">
                                <label class="form-label">Žanrs</label>
                                <select name="genre_id"
                                    class="form-select bg-dark text-light border-0 rounded"
                                    required>
                                    <option value="">Izvēlies žanru</option>
                                    @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">
                                        {{ $genre->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex justify-content-between align-items-center mt-4">

                                <a href="{{ route('cases.my-cases') }}"
                                    class="btn btn-outline-light rounded">
                                    Atpakaļ
                                </a>

                                <button type="submit"
                                    class="btn btn-primary rounded px-4">
                                    Tālāk →
                                </button>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>
