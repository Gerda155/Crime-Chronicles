<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Jauna lieta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            Jaunas lietas izveide
        </h1>

        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>1. solis no 4</span>
                <span>Pamatinformācija</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 20%;"></div>
            </div>
        </div>

        <div class="alert alert-dark border-0 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="display-6"><i class="fa-solid fa-user-secret"></i></div>
                <div>
                    <strong>Sveicināts, detektīv!</strong><br>
                    Tu esi uzsācis jaunas krimināllietas izveidi. Šis būs noslēpums, ko citi spēlētāji centīsies atrisināt.<br>
                    Vispirms piešķir lietai <strong>nosaukumu</strong>, uzraksti <strong>apsaucošu aprakstu</strong> un izvēlies atbilstošu <strong>žanru</strong>.<br>
                    <small class="text-secondary"><i class="fa-solid fa-lightbulb" style="color: #dabe69;"></i> Padoms: Jo detaļām bagātāks stāsts, jo interesantāka būs spēle!</small>
                </div>
            </div>
        </div>

        <div class="card bg-secondary text-light border-0">
            <div class="card-body">

                <form method="POST" action="{{ route('user.cases.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="fa-solid fa-pen"></i> Nosaukums</label>
                        <input type="text"
                            name="title"
                            class="form-control bg-dark text-light border-0 rounded"
                            placeholder="Ievadi lietas nosaukumu, piem., 'Rīgas noslēpums'"
                            required>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-info-circle"></i> Nosaukumam jābūt oriģinālam un atmiņā paliekošam
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="fa-solid fa-align-left"></i> Apraksts</label>
                        <textarea name="description"
                            rows="5"
                            class="form-control bg-dark text-light border-0 rounded"
                            placeholder="Apraksti lietas sižetu, noziegumu un galvenos notikumus..."
                            required></textarea>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-info-circle"></i> Detalizēts apraksts palīdzēs spēlētājam iegrimt stāstā
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="fa-solid fa-film"></i> Žanrs</label>
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
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-info-circle"></i> Žanrs noteiks lietas atmosfēru un stilu
                        </small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">

                        <a href="{{ route('cases.my-cases') }}"
                            class="btn btn-outline-light rounded px-4 py-2">
                            <i class="fa-solid fa-circle-arrow-left"></i> Atpakaļ
                        </a>

                        <button type="submit"
                            class="btn btn-primary rounded px-5 py-2">
                            Tālāk <i class="fa-solid fa-circle-arrow-right"></i>
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </main>

    @include('partials.footer')

</body>

</html>