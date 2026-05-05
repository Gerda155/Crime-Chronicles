<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <title>Crime Chronicles - Pierādījumi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .image-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }

        #previewImage {
            max-width: 100%;
            cursor: crosshair;
            border-radius: 8px;
            display: block;
        }

        .selection-box {
            position: absolute;
            border: 2px solid #ff4da6;
            background: rgba(255, 77, 166, 0.2);
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">
            Jautājumi
        </h1>

        <div class="text-center mb-3 text-secondary">
            Lieta: <strong class="text-light">{{ $case->title }}</strong>
        </div>

        {{-- LIST --}}
        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">

                <h5>Esošie jautājumi</h5>

                @forelse($questions as $q)
                <div class="border-bottom py-2">
                    <strong>❓ {{ $q->question_text }}</strong><br>
                    <small>👤 {{ $q->suspect->name ?? '—' }}</small><br>
                    <small class="text-muted">💬 {{ $q->answer_text }}</small>
                </div>
                @empty
                <p class="text-muted">Nav jautājumu</p>
                @endforelse

            </div>
        </div>

        {{-- FORM --}}
        <div class="card bg-secondary text-light border-0">
            <div class="card-body">

                <form method="POST" action="{{ route('cases.questions.store', $case->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Aizdomās turamais</label>
                        <select name="suspect_id" class="form-select bg-dark text-light border-0">
                            @foreach($suspects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jautājums</label>
                        <textarea name="question_text" class="form-control bg-dark text-light border-0"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Atbilde</label>
                        <textarea name="answer_text" class="form-control bg-dark text-light border-0"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">

                        <a href="{{ route('cases.evidence', $case->id) }}"
                            class="btn btn-outline-light">
                            Atpakaļ
                        </a>

                        <button class="btn btn-primary">
                            Pievienot
                        </button>

                    </div>

                </form>

            </div>
        </div>

        {{-- NEXT --}}
        <form method="POST" action="{{ route('cases.submit.final', $case->id) }}">
            @csrf

            <div class="text-end mt-4">
                <button class="btn btn-success">
                    Pabeigt lietu →
                </button>
            </div>
        </form>
    </main>

</body>

</html>