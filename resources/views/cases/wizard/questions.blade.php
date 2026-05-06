<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Jautājumi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold text-pink">
            Lietas: <strong class="text-light">"{{ $case->title }}"</strong> jautājumi
        </h1>

        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>4. solis no 4</span>
                <span>Jautājumi</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 100%;"></div>
            </div>
        </div>

        <div class="alert alert-dark border-0 mb-4">
            Uzstādi jautājumus aizdomās turamajiem (pēc izvēles).<br>
            Katram aizdomās turamajam vari pievienot vairākus jautājumus un atbildes.<br>
            <small class="text-secondary">Šobrīd pievienoti: {{ count($questions) }}</small>
        </div>

        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3">Esošie jautājumi</h5>

                @forelse($questions as $q)
                <div class="suspect-card w-100 mb-3 p-3 rounded">
                    <strong class="text-dark"><i class="fa-regular fa-circle-question"></i> {{ $q->question_text }}</strong><br>
                    <small class="text-light"><i class="fa-solid fa-circle-user"></i> {{ $q->suspect->name ?? '—' }}</small><br>
                    <small class="text-light"><i class="fa-solid fa-comment"></i> {{ $q->answer_text }}</small>
                </div>
                @empty
                <p class="text-muted">Nav pievienotu jautājumu (jautājumi nav obligāti)</p>
                @endforelse
            </div>
        </div>

        <div class="card bg-secondary text-light border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('cases.questions.store', $case->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Aizdomās turamais</label>
                        <select name="suspect_id" class="form-select bg-dark text-light border-0" required>
                            <option value="">Izvēlies aizdomās turamo</option>
                            @foreach($suspects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jautājums</label>
                        <textarea name="question_text" class="form-control bg-dark text-light border-0" rows="3" required placeholder="Ieraksti jautājumu..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Atbilde</label>
                        <textarea name="answer_text" class="form-control bg-dark text-light border-0" rows="3" required placeholder="Ieraksti atbildi..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cases.evidence', $case->id) }}"
                            class="btn btn-outline-light">
                            <i class="fa-solid fa-circle-arrow-left"></i> Atpakaļ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Pievienot jautājumu <i class="fa-solid fa-circle-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-end mt-4 d-flex justify-content-between">
            <a href="{{ route('cases.my-cases') }}" class="btn btn-outline-light">
                <i class="fa-solid fa-right-from-bracket"></i> Iziet
            </a>
            <form method="POST" action="{{ route('cases.submit.final', $case->id) }}" id="finalForm">
                @csrf
                <button type="submit" class="btn btn-success">
                    Pabeigt lietu <i class="fa-solid fa-circle-check"></i>
                </button>
            </form>
        </div>

    </main>

    @include('partials.footer')

</body>

</html>