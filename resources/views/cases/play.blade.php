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
                            <div class="evidence-img-wrapper mb-2 position-relative" style="width:100%; height:200px; overflow:hidden; border-radius:8px; cursor:zoom-in;">
                                <img src="{{ asset('storage/' . $item->image_path) }}"
                                    class="w-100 h-100 evidence-img"
                                    style="object-fit:contain;"
                                    data-key-area="{{ $item->key_object_area }}">
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
                            style="cursor:pointer;" data-suspect-id="{{ $suspect->id }}">
                            @if($suspect->image_path)
                            <img src="{{ asset('storage/' . $suspect->image_path) }}" alt="{{ $suspect->name }}" class="rounded mb-3" style="width:500px; height:500px; object-fit:cover;">
                            @endif
                            <strong class="fs-5">{{ $suspect->name }}</strong>
                            <p class="mb-0 text-light">{{ $suspect->description }}</p>

                            <div class="mt-3 questions d-none">

                                @if($questions->where('suspect_id', $suspect->id)->isEmpty())
                                <h6>Nav jautājumu, ko uzdot</h6>
                                @else
                                <h6 class="question-message">
                                    Atveriet vismaz 2 pierādījumus, lai veiktu pratināšanu
                                </h6>

                                <h6 class="msg d-none">
                                    Jūs varat veikt pratināšanu, izvēloties kādu no jautājumiem:
                                </h6>

                                <div class="d-flex flex-wrap gap-2 mb-3 question-buttons" style="justify-content:center; display:none;">
                                    @foreach($questions as $q)
                                    <div class="question {{ $q->is_locked ? 'locked-question d-none' : '' }}">
                                        <button type="button" class="btn btn-outline-info ask-btn" style="margin-top: 10px">
                                            {{ $q->question_text }}
                                        </button>
                                        <div class="answer mt-1 d-none">
                                            {{ $q->answer_text }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    @endforeach

                    <button type="button" class="btn btn-outline-light position-absolute top-50 start-0 translate-middle-y" id="prevSuspect" style="z-index:10;">&#8592;</button>
                    <button type="button" class="btn btn-outline-light position-absolute top-50 end-0 translate-middle-y" id="nextSuspect" style="z-index:10;">&#8594;</button>

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
        document.addEventListener('DOMContentLoaded', () => {
            new bootstrap.Modal(document.getElementById('answerModal')).show();
        });
    </script>
    @endif

    @if(session('last_attempt_correct') === true && !auth()->user()->hasRatedCase($case->id))
    <div class="modal fade" id="ratingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light border border-warning">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Novērtē lietu</h5>
                </div>
                <div class="modal-body text-center">
                    <form id="ratingForm" action="{{ route('ratings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}">

                        <div class="mb-3 rating-stars d-flex justify-content-center gap-1" style="font-size:2rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="star" data-value="{{ $i }}" style="cursor:pointer; color: #555;">
                                <input type="radio" name="rating" value="{{ $i }}" required style="display:none;">
                                &#9733;
                                </label>
                                @endfor
                        </div>

                        <textarea name="comment" class="form-control mb-3" placeholder="Komentārs..."></textarea>
                        <button type="submit" class="btn btn-warning w-100">Saglabāt</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.rating-stars .star');
            let selectedValue = 0;

            stars.forEach(star => {
                const value = parseInt(star.dataset.value);

                star.addEventListener('mouseenter', () => {
                    highlightStars(value);
                });

                star.addEventListener('mouseleave', () => {
                    highlightStars(selectedValue);
                });

                star.addEventListener('click', () => {
                    selectedValue = value;
                    star.querySelector('input').checked = true;
                    highlightStars(selectedValue);
                });
            });

            function highlightStars(rating) {
                stars.forEach(star => {
                    const value = parseInt(star.dataset.value);
                    star.style.color = value <= rating ? '#ffc107' : '#555';
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ratingModalEl = document.getElementById('ratingModal');
            const ratingModal = new bootstrap.Modal(ratingModalEl);
            ratingModal.show();

            document.getElementById('ratingForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: formData
                }).then(() => ratingModal.hide());
            });
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
                    <img src="{{ session('achievement.icon') ? asset('storage/' . session('achievement.icon')) : asset('storage/achievements/default.png') }}" class="mx-auto mb-3" width="100" height="100" style="object-fit: contain;">
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
        document.addEventListener('DOMContentLoaded', () => {
            new bootstrap.Modal(document.getElementById('achievementModal')).show();
        });
    </script>
    @endif
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark" style="height: 100vh;">
                <div class="modal-body position-relative p-0" style="height: 100vh; display: flex; justify-content: center; align-items: center; background: #000;">
                    <div style="position: relative; display: inline-block;">
                        <img id="modalImage" src="" style="max-width: 100vw; max-height: 100vh; object-fit: contain; cursor: default;">
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 1001; background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 10px;"></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrappers = document.querySelectorAll('.evidence-img-wrapper');
            const imageModalEl = document.getElementById('imageModal');
            const imageModal = new bootstrap.Modal(imageModalEl);
            const modalImg = document.getElementById('modalImage');

            let currentKeyArea = null;
            let currentImg = null;
            let currentWrapper = null;

            wrappers.forEach(wrapper => {
                const img = wrapper.querySelector('.evidence-img');
                let keyArea = null;

                if (img.dataset.keyArea && img.dataset.keyArea !== 'null' && img.dataset.keyArea !== '') {
                    try {
                        keyArea = JSON.parse(img.dataset.keyArea);
                        console.log('Key area loaded for:', img.src, keyArea);
                    } catch (e) {
                        console.error('Invalid key area data:', img.dataset.keyArea);
                    }
                }

                wrapper.addEventListener('click', (e) => {
                    e.stopPropagation();

                    currentKeyArea = keyArea;
                    currentImg = modalImg;
                    currentWrapper = wrapper;

                    modalImg.src = img.src;

                    modalImg.removeEventListener('mousemove', handleModalMouseMove);
                    modalImg.removeEventListener('click', handleModalClick);

                    if (keyArea) {
                        modalImg.style.cursor = 'crosshair';
                        modalImg.addEventListener('mousemove', handleModalMouseMove);
                        modalImg.addEventListener('click', handleModalClick);
                    } else {
                        modalImg.style.cursor = 'zoom-in';
                    }

                    imageModal.show();
                });
            });

            function handleModalMouseMove(e) {
                if (!currentKeyArea || !currentImg) return;

                const rect = currentImg.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const clickY = e.clientY - rect.top;

                const scaleX = currentImg.clientWidth / currentImg.naturalWidth;
                const scaleY = currentImg.clientHeight / currentImg.naturalHeight;

                const keyAreaX = currentKeyArea.x * scaleX;
                const keyAreaY = currentKeyArea.y * scaleY;
                const keyAreaW = currentKeyArea.width * scaleX;
                const keyAreaH = currentKeyArea.height * scaleY;

                if (clickX >= keyAreaX && clickX <= keyAreaX + keyAreaW &&
                    clickY >= keyAreaY && clickY <= keyAreaY + keyAreaH) {
                    currentImg.style.cursor = 'pointer';
                } else {
                    currentImg.style.cursor = 'crosshair';
                }
            }

            function handleModalClick(e) {
                if (!currentKeyArea || !currentImg || !currentWrapper) return;

                const rect = currentImg.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const clickY = e.clientY - rect.top;

                const scaleX = currentImg.clientWidth / currentImg.naturalWidth;
                const scaleY = currentImg.clientHeight / currentImg.naturalHeight;

                const keyAreaX = currentKeyArea.x * scaleX;
                const keyAreaY = currentKeyArea.y * scaleY;
                const keyAreaW = currentKeyArea.width * scaleX;
                const keyAreaH = currentKeyArea.height * scaleY;

                if (clickX >= keyAreaX && clickX <= keyAreaX + keyAreaW &&
                    clickY >= keyAreaY && clickY <= keyAreaY + keyAreaH) {

                    if (!currentWrapper.dataset.found) {
                        currentWrapper.dataset.found = 'true';

                        let opened = parseInt(openedInput.value) || 0;
                        opened++;
                        openedInput.value = opened;

                        if (opened >= 2) {
                            document.querySelectorAll('.locked-question').forEach(q => q.classList.remove('d-none'));
                            document.querySelectorAll('.question-buttons').forEach(q => q.style.display = 'flex');
                            document.querySelectorAll('.question-message').forEach(m => m.classList.add('d-none'));
                            document.querySelectorAll('.msg').forEach(m => m.classList.remove('d-none'));
                        }

                        if (submitBtn) submitBtn.disabled = opened < 2;

                        showEvidenceNotification('Pierādījums atrasts!');
                    } else {
                        showEvidenceNotification('Jūs jau atradāt šo pierādījumu!', 'warning');
                    }
                }
            }

            imageModalEl.addEventListener('hidden.bs.modal', () => {
                if (modalImg) {
                    modalImg.removeEventListener('mousemove', handleModalMouseMove);
                    modalImg.removeEventListener('click', handleModalClick);
                    modalImg.style.cursor = 'default';
                }
                currentKeyArea = null;
                currentImg = null;
                currentWrapper = null;
            });

            const buttons = document.querySelectorAll('.reveal-btn');
            const submitBtn = document.getElementById('submitBtn');
            const openedInput = document.getElementById('openedEvidenceCount');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const content = btn.nextElementSibling;
                    const isHidden = content.classList.contains('d-none');

                    if (isHidden) {
                        content.classList.remove('d-none');
                        btn.textContent = 'Paslēpt';

                        const img = content.querySelector('.evidence-img');
                        let counted = false;

                        if (img && img.dataset.keyArea && img.dataset.keyArea !== 'null' && img.dataset.keyArea !== '') {
                            counted = true;
                        }

                        if (!counted && !content.dataset.counted) {
                            content.dataset.counted = 'true';
                            let opened = parseInt(openedInput.value) || 0;
                            opened++;
                            openedInput.value = opened;

                            if (opened >= 2) {
                                document.querySelectorAll('.locked-question').forEach(q => q.classList.remove('d-none'));
                                document.querySelectorAll('.question-buttons').forEach(q => q.style.display = 'flex');
                                document.querySelectorAll('.question-message').forEach(m => m.classList.add('d-none'));
                                document.querySelectorAll('.msg').forEach(m => m.classList.remove('d-none'));
                            }

                            if (submitBtn) submitBtn.disabled = opened < 2;
                        }

                    } else {
                        content.classList.add('d-none');
                        btn.textContent = 'Atvērt pierādījumu';
                    }
                });
            });


            document.querySelectorAll('.ask-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const allAnswers = btn.closest('.questions').querySelectorAll('.answer');
                    allAnswers.forEach(a => a.classList.add('d-none'));

                    const answer = btn.nextElementSibling;
                    answer.classList.remove('d-none');
                });
            });

            const cards = document.querySelectorAll('.suspect-card');

            cards.forEach(card => {
                card.addEventListener('click', () => {
                    document.querySelectorAll('.questions').forEach(q => q.classList.add('d-none'));

                    const questions = card.querySelector('.questions');
                    if (questions) questions.classList.remove('d-none');
                });
            });

            const slides = document.querySelectorAll('.suspect-slide');
            let current = 0;

            const showSlide = (index) => slides.forEach((s, i) => s.classList.toggle('d-none', i !== index));

            const prevBtn = document.getElementById('prevSuspect');
            const nextBtn = document.getElementById('nextSuspect');

            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', () => {
                    current = (current - 1 + slides.length) % slides.length;
                    showSlide(current);
                });

                nextBtn.addEventListener('click', () => {
                    current = (current + 1) % slides.length;
                    showSlide(current);
                });
            }

            const suspectCards = document.querySelectorAll('.suspect-card');
            const selectedInput = document.getElementById('selectedSuspectId');

            suspectCards.forEach(card => {
                card.addEventListener('click', () => {
                    suspectCards.forEach(c => c.classList.remove('border-warning'));
                    card.classList.add('border-warning');
                    if (selectedInput) {
                        selectedInput.value = card.dataset.suspectId;
                    }
                });
            });
        });

        function showEvidenceNotification(message, type = 'info') {
            const notif = document.createElement('div');
            notif.className = `evidence-notification ${type}`;
            notif.innerHTML = `
            ${message}
                <br>
                <button class="btn btn-sm btn-dark">Labi</button>
            `;
            document.body.appendChild(notif);

            setTimeout(() => notif.classList.add('show'), 50);

            notif.querySelector('button').addEventListener('click', () => {
                notif.classList.remove('show');
                setTimeout(() => notif.remove(), 500);
            });

            setTimeout(() => {
                notif.classList.remove('show');
                setTimeout(() => notif.remove(), 500);
            }, 3000);
        }

        function showDialog(message, buttons = [{
            text: 'Labi',
            callback: null
        }]) {
            const dialog = document.createElement('div');
            dialog.className = 'dialog-box';
            dialog.innerHTML = `<p>${message}</p>`;

            buttons.forEach(btn => {
                const buttonEl = document.createElement('button');
                buttonEl.className = 'btn btn-outline-light';
                buttonEl.textContent = btn.text;
                buttonEl.addEventListener('click', () => {
                    if (btn.callback) btn.callback();
                    dialog.classList.remove('show');
                    setTimeout(() => dialog.remove(), 400);
                });
                dialog.appendChild(buttonEl);
            });

            document.body.appendChild(dialog);
            setTimeout(() => dialog.classList.add('show'), 50);

            setTimeout(() => {
                if (document.body.contains(dialog)) {
                    dialog.classList.remove('show');
                    setTimeout(() => dialog.remove(), 400);
                }
            }, 5000);
        }
    </script>

    @include('partials.footer')
</body>

</html>