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
    </style>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold text-pink">
            Lietas: <strong class="text-light">"{{ $case->title }}"</strong> aizdomās turamie
        </h1>

        {{-- STEP INFO --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>2. solis no 4</span>
                <span>Aizdomās turamais</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 40%;"></div>
            </div>
        </div>

        {{-- EXPLANATION --}}
        <div class="alert alert-dark border-0 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="display-6"><i class="fa-solid fa-user-secret"></i></div>
                <div>
                    Katrai lietai ir vajadzīgi <strong class="text-pink">aizdomās turamie</strong>. Tev jāpievieno vismaz 2 cilvēki,
                    kurus spēlētāji turēs aizdomās par noziegumu.<br>
                    Viens no viņiem ir <strong class="text-pink">īstais vainīgais</strong> - atzīmē viņu zemāk esošajā sarakstā.<br>
                </div>
            </div>
        </div>

        <div class="alert alert-secondary border-0 mb-4">
            Izvēlētais vainīgais:
            <strong id="selectedName">
                {{ $case->answer_id ? $suspects->firstWhere('id', $case->answer_id)->name : 'Nav izvēlēts' }}
            </strong>
        </div>

        {{-- AIZDOMĀS TURAMO SARAKSTS (ĀRPUS FORMAS) --}}
        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3">Aizdomās turamie</h5>

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
                        <span class="text-secondary">📷</span>
                    </div>
                    @endif

                    <div class="flex-grow-1">
                        <strong>{{ $suspect->name }}</strong><br>
                        <small class="text-light opacity-75">
                            {{ $suspect->description }}
                        </small>
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- FORMA VAINĪGĀ SAGLABĀŠANAI --}}
        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('cases.suspects.setAnswer', $case->id) }}" id="answerForm">
                    @csrf

                    @foreach($suspects as $suspect)
                    <input type="radio"
                        name="answer_id"
                        value="{{ $suspect->id }}"
                        id="suspect_{{ $suspect->id }}"
                        class="d-none"
                        {{ $case->answer_id == $suspect->id ? 'checked' : '' }}>
                    @endforeach

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Saglabāt vainīgo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- FORMA JAUNU AIZDOMĀS TURAMO PIEVIENOŠANAI --}}
        <div class="card bg-secondary text-light border-0">
            <div class="card-body">
                <h5 class="mb-3">Pievienot jaunu aizdomās turamo</h5>

                <form method="POST"
                    action="{{ route('cases.suspects.store', $case->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Vārds</label>
                        <input type="text" name="name"
                            class="form-control bg-dark text-light border-0"
                            required>
                        <small class="text-light mt-1 d-block"> Iedomājies aizdomīgu tēlu. Vārds ir pirmais, ko spēlētājs ieraudzīs</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apraksts</label>
                        <textarea name="description"
                            class="form-control bg-dark text-light border-0"
                            rows="3"></textarea>
                        <small class="text-light mt-1 d-block">
                            Apraksti viņa izskatu, raksturu, uzvedību un iespējamo saistību ar noziegumu
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Attēls</label>
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
                            <small class="text-light mt-1 d-block">
                                Pievieno attēlu, lai aizdomās turamais izskatītos reālistisks (JPG, PNG, GIF, max. 5MB) <br> Atbalstītie formāti: JPG, PNG, GIF (max. 5MB)
                            </small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cases.suspects', $case->id) }}"
                            class="btn btn-outline-light">
                            <i class="fa-solid fa-circle-arrow-left"></i> Atpakaļ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-circle-plus"></i> Pievienot
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- NEXT STEP --}}
        <div class="text-end mt-4 d-flex justify-content-between">
            <a href="{{ route('cases.my-cases') }}"
                class="btn btn-outline-light">
                <i class="fa-solid fa-right-from-bracket"></i> Iziet
            </a>
            <a href="{{ route('cases.evidence', $case->id) }}"
                id="nextBtn"
                class="btn btn-success {{ count($suspects) < 2 ? 'disabled' : '' }}">
                Tālāk <i class="fa-solid fa-circle-arrow-right"></i>
            </a>
        </div>

    </main>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Saglabāt vainīgo formu apstrāde ar AJAX, lai nerodas redirect
            const answerForm = document.getElementById('answerForm');
            if (answerForm) {
                answerForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Nekoļauj formai atstāt lapu

                    const formData = new FormData(this);

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Parādām paziņojumu
                                showToast('success', 'Vainīgais saglabāts!');
                            } else {
                                showToast('error', 'Kļūda saglabājot vainīgo');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('error', 'Kļūda saglabājot vainīgo');
                        });
                });
            }

            // Paziņojumu funkcija
            function showToast(type, message) {
                const toast = document.createElement('div');
                toast.className = `toast-notification ${type}`;
                toast.innerHTML = `
        <div class="toast-content">
            <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
            <span>${message}</span>
        </div>
    `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('show');
                }, 100);

                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
            const cards = document.querySelectorAll('.suspect-card');
            const nextBtn = document.getElementById('nextBtn');
            const selectedName = document.getElementById('selectedName');
            const suspectsCount = parseInt('{{ count($suspects) }}');
            const radios = document.querySelectorAll('input[name="answer_id"]');

            // Ja jau ir izvēlēts (pie ielādes)
            cards.forEach((card, index) => {
                const suspectId = card.dataset.id;
                const radio = document.getElementById(`suspect_${suspectId}`);
                if (radio && radio.checked) {
                    card.classList.add('selected');
                }
            });

            // Kartīšu klikšķu apstrāde (tikai vizuāla, bez formas submit)
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Neaktivizēt, ja klikšķis uz pogas vai formas elementiem
                    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'INPUT' || e.target.tagName === 'A') {
                        return;
                    }

                    const suspectId = this.dataset.id;
                    const radio = document.getElementById(`suspect_${suspectId}`);

                    if (radio) {
                        // Noņem 'selected' no visām kartītēm
                        cards.forEach(c => c.classList.remove('selected'));

                        // Pievieno 'selected' klikšķinātajai kartītei
                        this.classList.add('selected');

                        // Atzīmē radio pogu
                        radios.forEach(r => r.checked = false);
                        radio.checked = true;

                        // Atjauno tekstu par izvēlēto vainīgo
                        if (selectedName) {
                            selectedName.textContent = this.dataset.name;
                        }
                    }

                    // Atjauno pogas "Tālāk" stāvokli
                    updateNextButton();
                });
            });

            // Funkcija pogas "Tālāk" atjaunošanai
            function updateNextButton() {
                const selected = document.querySelector('input[name="answer_id"]:checked');

                if (suspectsCount >= 2 && selected) {
                    nextBtn.classList.remove('disabled');
                    nextBtn.removeAttribute('disabled');
                } else {
                    nextBtn.classList.add('disabled');
                    nextBtn.setAttribute('disabled', 'disabled');
                }
            }

            // Sākotnējais pogas stāvoklis
            updateNextButton();

            // File input name display
            const fileInput = document.getElementById('imageInput');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const fileName = this.files[0]?.name || 'Nav izvēlēts fails';
                    const label = this.parentElement.querySelector('.file-name');
                    if (label) {
                        label.textContent = fileName;
                    }
                    if (this.files.length > 0) {
                        this.parentElement.classList.add('has-file');
                    } else {
                        this.parentElement.classList.remove('has-file');
                    }
                });
            }
        });
    </script>

</body>

</html>