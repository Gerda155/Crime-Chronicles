<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - {{ $case->title }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <div class="mb-5 text-center">
            <h1 class="display-4">{{ $case->title }}</h1>
            <p class="lead">{{ $case->description }}</p>
        </div>

        <section>
            <h3 class="mb-4 border-bottom pb-2">Pierādījumi</h3>
            <div class="row g-4">
                @foreach($evidence as $item)
                <div class="col-md-4">
                    <div class="card bg-secondary text-light evidence-card h-100 p-3">
                        <button type="button" class="btn btn-outline-light btn-sm reveal-btn mb-2">
                            Atvērt pierādījumu
                        </button>
                        <div class="evidence-content d-none">
                            <p>{{ $item->description }}</p>
                            @if($item->type === 'image' && $item->image_path)
                            <div class="evidence-img-wrapper mb-2" style="width:100%; height:200px; overflow:hidden; border-radius:8px;">
                                <img src="{{ asset('storage/' . $item->image_path) }}"
                                    class="w-100 h-100"
                                    style="object-fit:contain;">
                            </div>
                            @elseif($item->type === 'report' && $item->image_path)
                            <a href="{{ asset('storage/' . $item->image_path) }}" target="_blank" class="btn btn-outline-light btn-sm">
                                Skatīt atskaiti
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <section class="mt-4">
            <h3 class="mb-4 border-bottom pb-2">Aizdomās turamie</h3>
            <form action="{{ route('cases.submit', $case->id) }}" method="POST" id="caseForm">
                @csrf
                <input type="hidden" name="opened_evidence_count" id="openedEvidenceCount" value="0">

                <div class="suspect-carousel position-relative text-center">
                    @foreach($suspects as $index => $suspect)
                    <div class="suspect-slide {{ $index === 0 ? '' : 'd-none' }}" data-index="{{ $index }}">
                        <div class="suspect-card p-3 d-flex flex-column align-items-center bg-secondary text-light shadow-sm border-2 rounded"
                            style="cursor:pointer;"
                            data-suspect-id="{{ $suspect->id }}">

                            @if($suspect->image_path)
                            <img src="{{ asset('storage/' . $suspect->image_path) }}"
                                alt="{{ $suspect->name }}"
                                class="rounded mb-3"
                                style="width:500px; height:500px; object-fit:cover;">
                            @endif

                            <strong class="fs-5">{{ $suspect->name }}</strong>
                            <p class="mb-0 text-light">{{ $suspect->description }}</p>
                        </div>
                    </div>
                    @endforeach

                    {{-- Стрелки --}}
                    <button type="button" class="btn btn-outline-light position-absolute top-50 start-0 translate-middle-y" id="prevSuspect" style="z-index:10;">&#8592;</button>
                    <button type="button" class="btn btn-outline-light position-absolute top-50 end-0 translate-middle-y" id="nextSuspect" style="z-index:10;">&#8594;</button>

                    {{-- Хранение выбранного --}}
                    <input type="hidden" name="suspect_id" id="selectedSuspectId" value="">
                </div>

                <button type="submit" class="btn btn-success btn-lg mt-4 w-100" id="submitBtn" disabled>Iesniegt atbildi</button>
            </form>
        </section>
    </main>

    @if(session('status'))
    <div class="modal fade" id="answerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light border border-info">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">{{ session('last_attempt_correct') ? 'Pareizi!' : 'Nepareizi' }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fw-bold">{{ session('status') }}</p>
                    @if($case->solution_explanation && session('last_attempt_correct') === true)
                    <hr class="bg-light">
                    <h6 class="fw-bold">Risinājuma skaidrojums:</h6>
                    <p>{{ session('explanation') }}</p>
                    @endif
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Labi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var answerModal = new bootstrap.Modal(document.getElementById('answerModal'));
            answerModal.show();
        });
    </script>
    @endif

    @if(session('achievement'))
    <div class="modal fade" id="achievementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light border border-warning">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Jauns sasniegums!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img
                        src="{{ session('achievement.icon') ? asset('storage/' . session('achievement.icon')) : asset('storage/achievements/default.png') }}"
                        class="mx-auto mb-3" width="100" height="100" style="object-fit: contain;">
                    <h6 class="fw-bold mt-2">{{ session('achievement.title') }}</h6>
                    <p class="mb-0">{{ session('achievement.description') }}</p>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Labi!</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var achievementModal = new bootstrap.Modal(document.getElementById('achievementModal'));
            achievementModal.show();
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.reveal-btn');
            const submitBtn = document.getElementById('submitBtn');
            const openedInput = document.getElementById('openedEvidenceCount');
            let opened = 0;

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const wasHidden = content.classList.contains('d-none');
                    content.classList.toggle('d-none');

                    opened += wasHidden ? 1 : -1;
                    openedInput.value = opened;

                    submitBtn.disabled = opened < 2;

                    this.textContent = content.classList.contains('d-none') ? 'Atvērt pierādījumu' : 'Paslēpt';
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.suspect-slide');
            let current = 0;

            const showSlide = (index) => {
                slides.forEach((slide, i) => slide.classList.toggle('d-none', i !== index));
            };

            document.getElementById('prevSuspect').addEventListener('click', () => {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);
            });

            document.getElementById('nextSuspect').addEventListener('click', () => {
                current = (current + 1) % slides.length;
                showSlide(current);
            });

            const cards = document.querySelectorAll('.suspect-card');
            const selectedInput = document.getElementById('selectedSuspectId');

            cards.forEach(card => {
                card.addEventListener('click', () => {
                    cards.forEach(c => c.classList.remove('border-warning'));
                    card.classList.add('border-warning');
                    selectedInput.value = card.dataset.suspectId;
                });
            });
        });
    </script>
    @include('partials.footer')
</body>

</html>