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
                            @if($item->type === 'image')
                            <img src="{{ asset('storage/' . $item->content) }}"
                                class="img-fluid rounded mb-2"
                                style="max-height:200px; object-fit:cover;">
                            @endif
                            <p>{{ $item->description }}</p>
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

                <div class="row g-3">
                    @foreach($suspects as $suspect)
                    <div class="col-md-6">
                        <label class="card suspect-card p-3 d-flex align-items-center gap-3 bg-secondary text-light" for="suspect-{{ $suspect->id }}">
                            <input class="form-check-input mt-0" type="radio" name="suspect_id" value="{{ $suspect->id }}" id="suspect-{{ $suspect->id }}">
                            <div>
                                <strong>{{ $suspect->name }}</strong>
                                <p class="mb-0">{{ $suspect->description }}</p>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success btn-lg mt-4 w-100" id="submitBtn" disabled>Iesniegt atbildi</button>
            </form>

            @if(session('status'))
            <div class="alert alert-info mt-4 text-center fw-bold">
                {{ session('status') }}
            </div>
            @endif
        </section>
    </main>

    {{-- Achievement Modal --}}
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

    @include('partials.footer')
</body>

</html>