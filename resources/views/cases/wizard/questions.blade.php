<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Jautājumi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold ">
            Lietas: <strong class="text-light">"{{ $case->title }}"</strong> jautājumi
        </h1>

        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>4. solis no 4</span>
                <span>Jautājumi</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 80%;"></div>
            </div>
        </div>

        {{-- EXPLANATION --}}
        <div class="alert alert-dark border-0 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="display-6"><i class="fa-solid fa-circle-question"></i></div>
                <div>
                    <strong>Detektīv, ir laiks veikt nopratināšanu!</strong><br>
                    Tagad vari pievienot <strong>jautājumus</strong> aizdomās turamajiem. 
                    Šie jautājumi palīdzēs spēlētājam labāk izprast lietu un atklāt patiesību.<br>
                    Jautājumi nav obligāti, bet tie padara spēli <strong>interesantāku un dziļāku</strong>!<br>
                    <small class="text-secondary"><i class="fa-solid fa-lightbulb" style="color: #dabe69;"></i> Padoms: Uzdod jautājumus, kas atklāj aizdomās turamā raksturu un motivāciju!</small><br>
                    <small>Pašlaik pievienoti: {{ count($questions) }} jautājumi</small>
                </div>
            </div>
        </div>

        {{-- JAUTĀJUMU SARAKSTS --}}
        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3"><i class="fa-solid fa-list"></i> Esošie jautājumi</h5>

                @forelse($questions as $q)
                <div class="suspect-card w-100 mb-3 p-3 rounded">
                    <strong><i class="fa-regular fa-circle-question"></i> {{ $q->question_text }}</strong><br>
                    <small class="text-info"><i class="fa-solid fa-circle-user"></i> Jautā: {{ $q->suspect->name ?? '—' }}</small><br>
                    <small class="text-light"><i class="fa-solid fa-comment-dots"></i> Atbilde: {{ $q->answer_text }}</small>
                </div>
                @empty
                <p class="text-muted text-center py-3"><i class="fa-solid fa-folder-open"></i> Nav pievienotu jautājumu (jautājumi nav obligāti)</p>
                @endforelse
            </div>
        </div>

        {{-- FORMA JAUTĀJUMA PIEVIENOŠANAI --}}
        <div class="card bg-secondary text-light border-0">
            <div class="card-body">
                <h5 class="mb-3"><i class="fa-solid fa-plus-circle"></i> Pievienot jaunu jautājumu</h5>
                
                <form method="POST" action="{{ route('cases.questions.store', $case->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-solid fa-user"></i> Aizdomās turamais</label>
                        <select name="suspect_id" class="form-select bg-dark text-light border-0" required>
                            <option value="">Izvēlies aizdomās turamo</option>
                            @foreach($suspects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-info-circle"></i> Izvēlies, kuram aizdomās turamajam šis jautājums tiks uzdots
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-regular fa-circle-question"></i> Jautājums</label>
                        <textarea name="question_text" class="form-control bg-dark text-light border-0" rows="3" required placeholder="Piem., 'Kur jūs atradāties nozieguma brīdī?'"></textarea>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-pen"></i> Uzraksti jautājumu, ko spēlētājs varēs uzdot aizdomās turamajam
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-solid fa-comment-dots"></i> Atbilde</label>
                        <textarea name="answer_text" class="form-control bg-dark text-light border-0" rows="3" required placeholder="Ieraksti atbildi, ko aizdomās turamais sniegs..."></textarea>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-info-circle"></i> Atbilde var saturēt norādes, melus vai svarīgu informāciju
                        </small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cases.evidence', $case->id) }}"
                            class="btn btn-outline-light">
                            <i class="fa-solid fa-circle-arrow-left"></i> Atpakaļ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-circle-plus"></i> Pievienot jautājumu
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- NEXT STEP --}}
        <div class="text-end mt-4 d-flex justify-content-between">
            <a href="{{ route('cases.my-cases') }}" class="btn btn-outline-light">
                <i class="fa-solid fa-right-from-bracket"></i> Iziet
            </a>
            <form method="POST" action="{{ route('cases.submit.final', $case->id) }}" id="finalForm">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-circle-check"></i> Pabeigt lietu
                </button>
            </form>
        </div>

    </main>

    @include('partials.footer')

</body>

</html>