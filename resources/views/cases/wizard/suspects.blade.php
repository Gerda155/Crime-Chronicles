<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Aizdomās turamie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    @php
    $editMode = $editMode ?? false;
    @endphp

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            Lietas: <strong class="text-light">"{{ $case->title }}"</strong> aizdomās turamie
        </h1>

        @if($editMode)
        <div class="alert alert-warning border-0 mb-4">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Pēc izmaiņu veikšanas lieta tiks atkārtoti nosūtīta moderācijai.
        </div>
        @endif

        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>2. solis no 4</span>
                <span>Aizdomās turamais</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 40%;"></div>
            </div>
        </div>

        <div class="alert alert-dark border-0 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="display-6"><i class="fa-solid fa-people-group"></i></div>
                <div>
                    <strong>Detektīv, šeit tu vari izveidot varoņus!</strong><br>
                    Katrai lietai ir vajadzīgi <strong>aizdomās turamie</strong>. Tev jāpievieno vismaz 2 cilvēki,
                    kurus spēlētāji turēs aizdomās par noziegumu.<br>
                    Viens no viņiem ir <strong>īstais vainīgais</strong> - vienkārši <strong>uzklikšķini</strong> uz viņa kartītes, lai atzīmētu!<br>
                    <small> Pašlaik pievienoti: <span id="suspectCount">{{ count($suspects) }}</span></small>
                </div>
            </div>
        </div>

        <div class="alert alert-secondary border-0 mb-4">
            <i class="fa-solid fa-gavel"></i> Izvēlētais vainīgais:
            <strong id="selectedName">
                {{ $case->answer_id ? $suspects->firstWhere('id', $case->answer_id)->name : 'Nav izvēlēts' }}
            </strong>
        </div>

        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3"><i class="fa-solid fa-list"></i> Aizdomās turamie</h5>
                @if(count($suspects) == 0)
                <p class="text-muted text-center py-3"><i class="fa-solid fa-folder-open"></i> Nav pievienotu aizdomās turamie</p>
                @endif
                @foreach($suspects as $suspect)
                <div class="suspect-card w-100 mb-3 p-3 rounded d-flex gap-3 align-items-center"
                    data-id="{{ $suspect->id }}"
                    data-name="{{ $suspect->name }}"
                    style="border:2px solid transparent;">

                    @if($suspect->image_path)
                    <img src="{{ asset($suspect->image_path) }}"
                        class="rounded"
                        width="60"
                        height="60"
                        style="object-fit: cover;">
                    @else
                    <div class="rounded bg-dark d-flex align-items-center justify-content-center"
                        style="width:60px; height:60px;">
                        <span class="text-secondary"><i class="fa-solid fa-user"></i></span>
                    </div>
                    @endif

                    <div class="flex-grow-1">
                        <strong> {{ $suspect->name }}</strong><br>
                        <small class="text-light opacity-75">
                            {{ $suspect->description }}
                        </small>
                    </div>

                    <div class="d-flex gap-2 mt-2">

                        <form method="POST"
                            action="{{ route('cases.suspects.destroy', [$case->id, $suspect->id]) }}">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                    </div>

                </div>
                @endforeach
            </div>
        </div>

        <div class="card bg-secondary text-light border-0">
            <div class="card-body">
                <h5 class="mb-3"><i class="fa-solid fa-plus-circle"></i> Pievienot jaunu aizdomās turamo</h5>

                <form method="POST"
                    action="{{ isset($editingSuspect)
                    ? route('cases.suspects.update', [$case->id, $editingSuspect->id])
                    : route('cases.suspects.store', $case->id) }}"
                    enctype="multipart/form-data">

                    @csrf

                    @if(isset($editingSuspect))
                    @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-solid fa-user"></i> Vārds</label>
                        <input type="text" name="name"
                            class="form-control bg-dark text-light border-0"
                            value="{{ old('name', $editingSuspect->name ?? '') }}"
                            required>
                        <small class="text-light mt-1 d-block"><i class="fa-solid fa-info-circle"></i> Iedomājies aizdomīgu tēlu. Vārds ir pirmais, ko spēlētājs ieraudzīs</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-solid fa-align-left"></i> Apraksts</label>
                        <textarea name="description"
                            class="form-control bg-dark text-light border-0"
                            rows="3">{{ old('description', $editingSuspect->description ?? '') }}</textarea>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-info-circle"></i> Apraksti viņa izskatu, raksturu, uzvedību un iespējamo saistību ar noziegumu
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-solid fa-image"></i> Attēls</label>
                        <div class="custom-file-input">
                            <input type="file"
                                name="image"
                                id="imageInput"
                                accept="image/*">
                            <label for="imageInput" class="custom-file-label">
                                <i class="fas fa-image"></i>
                                <span>Izvēlies failu</span>
                                <span class="file-name">Nav izvēlēts fails</span>
                            </label>
                        </div>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-camera"></i> Pievieno attēlu, lai aizdomās turamais izskatītos reālistisks (JPG, PNG, GIF, max. 5MB)
                        </small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('cases.suspects', $case->id) }}"
                            class="btn btn-outline-light">
                            <i class="fa-solid fa-circle-arrow-left"></i> Atpakaļ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-circle-plus"></i> Pievienot aizdomās turamo
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <div class="text-end mt-4 d-flex justify-content-between">
            <a href="{{ route('cases.my-cases') }}"
                class="btn btn-outline-light">
                <i class="fa-solid fa-right-from-bracket"></i> Iziet
            </a>
            <a href="{{ route('cases.evidence', $case->id) }}"
                id="nextBtn"
                class="btn btn-success {{
                    count($suspects) < 2 || !$case->answer_id
                    ? 'disabled'
                    : ''
                }}">
                Tālāk <i class="fa-solid fa-circle-arrow-right"></i>
            </a>
        </div>

    </main>

    @include('partials.footer')

    <div id="suspectData"
        data-suspects-count="{{ count($suspects) }}"
        data-current-answer-id="{{ $case->answer_id }}"
        data-current-answer-name="{{ $case->answer_id ? optional($suspects->firstWhere('id', $case->answer_id))->name : '' }}"
        data-set-answer-url="{{ route('cases.suspects.setAnswer', $case->id) }}"
        data-csrf-token="{{ csrf_token() }}"
        style="display: none;">
    </div>

    <script>
        const suspectDataElement = document.getElementById('suspectData');

        window.suspectData = {
            suspectsCount: parseInt(suspectDataElement.dataset.suspectsCount),
            currentAnswerId: suspectDataElement.dataset.currentAnswerId === '' ? null : parseInt(suspectDataElement.dataset.currentAnswerId),
            currentAnswerName: suspectDataElement.dataset.currentAnswerName === '' ? null : suspectDataElement.dataset.currentAnswerName,
            setAnswerUrl: suspectDataElement.dataset.setAnswerUrl,
            csrfToken: suspectDataElement.dataset.csrfToken
        };
    </script>

    <script src="{{ asset('js/constructor/suspect.js') }}"></script>

</body>

</html>