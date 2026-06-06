<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Cases</title>
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
            Moderatora panelis - Lieta "{{ $case->title }}"
        </h1>

        <div class="card bg-secondary-subtle text-dark border-0 shadow mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">{{ $case->title }}</h2>

                    <span class="badge bg-dark">
                        {{ strtoupper($case->status) }}
                    </span>
                </div>

                <div class="row g-3">

                    <div class="col-md-4">
                        <strong>Autors:</strong><br>
                        {{ $case->user->username ?? 'Nav zināms' }}
                    </div>

                    <div class="col-md-4">
                        <strong>Žanrs:</strong><br>
                        {{ $case->genre->name ?? 'Nav norādīts' }}
                    </div>

                    <div class="col-md-4">
                        <strong>Reitings:</strong><br>
                        {{ $case->rating }}
                    </div>

                </div>

                @if($case->preview)
                <hr>

                <h5>Priekšskatījuma attēls</h5>

                <img src="{{ asset('storage/' . $case->preview) }}"
                    class="img-fluid rounded shadow">
                @endif

                <hr>

                <h5>Apraksts</h5>

                <p class="mb-0">
                    {{ $case->description }}
                </p>

            </div>
        </div>

        <div class="card bg-dark border-secondary mb-4 text-light">
            <div class="card-header">
                <h4 class="mb-0">Pierādījumi</h4>
            </div>

            <div class="card-body">

                @forelse($case->evidence as $evidence)

                <div class="border-bottom border-secondary pb-3 mb-3">

                    <h5>{{ $evidence->title }}</h5>

                    <p>{{ $evidence->description }}</p>

                    @php
                    $extension = pathinfo($evidence->image_path, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                    <div class="evidence-img-wrapper mb-2 position-relative"
                        style="width:100%; height:200px; overflow:hidden; border-radius:8px; cursor:zoom-in;">

                        <img src="{{ asset($evidence->image_path) }}"
                            class="w-100 h-100 evidence-img"
                            style="object-fit:contain;"
                            data-key-area="{{ $evidence->key_object_area }}">
                    </div>

                    @elseif($evidence->image_path === null)

                    @else
                    <a href="{{ asset($evidence->image_path) }}"
                        target="_blank"
                        class="btn btn-outline-light">
                        Atvērt failu
                    </a>

                    @endif

                </div>

                @empty

                <p class="text-muted">
                    Nav pievienotu pierādījumu.
                </p>

                @endforelse

            </div>
        </div>

        <div class="card bg-dark border-secondary mb-4">
            <div class="card-header">
                <h4 class="mb-0">Aizdomās turamie</h4>
            </div>

            <div class="card-body">

                <div class="row">

                    @foreach($case->suspects as $suspect)

                    <div class="col-md-4 mb-4">

                        <div class="card h-100 bg-secondary-subtle text-dark">

                            @if($suspect->image_path)

                            <img src="{{ asset($suspect->image_path) }}"
                                class="card-img-top">

                            @endif

                            <div class="card-body">

                                <h5>{{ $suspect->name }}</h5>

                                <p>{{ $suspect->description }}</p>

                                @if($case->answer_id == $suspect->id)

                                <span class="badge bg-success">
                                    Pareizā atbilde
                                </span>

                                @endif

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>
        </div>

        <div class="card bg-dark border-secondary mb-4 text-light">
            <div class="card-header">
                <h4 class="mb-0">Jautājumi</h4>
            </div>

            <div class="card-body">

                @forelse($case->questions as $question)

                <div class="mb-4">

                    <p>
                        <strong>Aizdomās turams:</strong><br>
                        {{ $question->suspect->name }}
                    </p>

                    <p>
                        <strong>Jautājums:</strong><br>
                        {{ $question->question_text }}
                    </p>

                    <p>
                        <strong>Atbilde:</strong><br>
                        {{ $question->answer_text }}
                    </p>

                </div>

                @empty

                <p>Nav jautājumu.</p>

                @endforelse

            </div>
        </div>

        <div class="card bg-dark border-secondary mb-4 text-light">
            <div class="card-header">
                <h4 class="mb-0">Risinājuma skaidrojums</h4>
            </div>

            <div class="card-body">

                <p class="mb-0">
                    {{ $case->solution_explanation ?? 'Nav pievienots.' }}
                </p>

            </div>
        </div>

        <a href="{{ route('moderator.cases.index') }}"
            class="btn btn-outline-light">
            <i class="fa-solid fa-arrow-left"></i>
            Atpakaļ
        </a>

    </main>
    @include('partials.footer')

</body>

</html>