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

        <div id="scoreDisplay" style="font-weight: bold; margin-bottom: 10px;">
            Punkti: {{ $progress->score ?? 0 }}
        </div>

        <div class="progress mb-3">
            <div
                class="progress-bar bg-info"
                role="progressbar"
                style="width: {{ isset($progressPercent) ? $progressPercent : 0 }}%;">
                {{ isset($progressPercent) ? round($progressPercent) : 0 }}%
            </div>
        </div>

        <section id="evidence-section">
            <h3 class="mb-4 border-bottom pb-2">Pierādījumi</h3>
            <div class="row g-4">
                @foreach($evidence as $index => $item)
                <div class="col-md-4" data-evidence-index="{{ $index }}">
                    <div class="card bg-secondary text-light evidence-card h-100 p-3">
                        <button type="button" class="btn btn-outline-light btn-sm reveal-btn mb-2" data-evidence-btn="{{ $index }}">
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

        <section class="mt-4" id="suspects-section">
            <h3 class="mb-4 border-bottom pb-2">Aizdomās turamie</h3>
            <form action="{{ route('cases.submit', $case->id) }}" method="POST" id="caseForm">
                @csrf
                <input type="hidden"
                    name="opened_evidence_count"
                    id="openedEvidenceCount"
                    value="{{ $progress->opened_evidence ?? 0 }}">

                <div class="suspect-carousel position-relative text-center">
                    @foreach($suspects as $index => $suspect)
                    <div class="suspect-slide {{ $index === 0 ? '' : 'd-none' }}" data-index="{{ $index }}" data-suspect-index="{{ $index }}">
                        <div class="suspect-card p-3 d-flex flex-column align-items-center bg-secondary text-light shadow-sm border-2 rounded"
                            style="cursor:pointer;" data-suspect-id="{{ $suspect->id }}" data-suspect-name="{{ $suspect->name }}">
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
                                    <div class="question {{ $q->is_locked ? 'locked-question d-none' : '' }}" data-question-id="{{ $q->id }}">
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
                    <input type="hidden" name="score" id="scoreInput" value="0">
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
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-stars .star');
            let selectedValue = 0;

            stars.forEach(function(star) {
                const value = parseInt(star.dataset.value);

                star.addEventListener('mouseenter', function() {
                    highlightStars(value);
                });

                star.addEventListener('mouseleave', function() {
                    highlightStars(selectedValue);
                });

                star.addEventListener('click', function() {
                    selectedValue = value;
                    star.querySelector('input').checked = true;
                    highlightStars(selectedValue);
                });
            });

            function highlightStars(rating) {
                stars.forEach(function(star) {
                    const value = parseInt(star.dataset.value);
                    star.style.color = value <= rating ? '#ffc107' : '#555';
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                }).then(function() {
                    ratingModal.hide();
                });
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
        document.addEventListener('DOMContentLoaded', function() {
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
        const TutorialSystem = {
            isActive: {{ isset($isTutorial) && $isTutorial ? 'true' : 'false' }},
            currentStep: 0,
            overlay: null,
            tutorialBox: null,
            highlightedElement: null,
            stepsCompleted: [],
            
            steps: [
                {
                    title: "Sveicināts!",
                    text: "Šī ir mācību lieta. Es Tevi iepazīstināšu ar spēli.",
                    trigger: null,
                    highlightElement: null,
                    position: "center"
                },
                {
                    title: "1. solis",
                    text: "Noklikšķini uz pogas 'Atvērt pierādījumu'",
                    trigger: "evidence_click",
                    highlightSelector: ".reveal-btn",
                    position: "bottom"
                },
                {
                    title: "2. solis",
                    text: "Atrodi slēpto objektu bildē un noklikšķini uz tā",
                    trigger: "hidden_object",
                    highlightSelector: ".evidence-img-wrapper",
                    position: "top"
                },
                {
                    title: "3. solis",
                    text: "Atver vēl vienu pierādījumu (vajag 2)",
                    trigger: "evidence_count_2",
                    highlightSelector: ".reveal-btn",
                    position: "bottom"
                },
                {
                    title: "4. solis",
                    text: "Noklikšķini uz aizdomās turamā un uzdod jautājumu",
                    trigger: "ask_question",
                    highlightSelector: ".ask-btn",
                    position: "right"
                },
                {
                    title: "5. solis",
                    text: "Izvēlies aizdomās turamo (noklikšķini uz kartītes)",
                    trigger: "select_suspect",
                    highlightSelector: ".suspect-card",
                    position: "bottom"
                },
                {
                    title: "Apsveicu!",
                    text: "Tagad esi gatavs risināt īstas lietas! Veiksmi!",
                    trigger: null,
                    highlightElement: null,
                    position: "center"
                }
            ],
            
            init: function() {
                if (!this.isActive) return;
                
                this.overlay = document.createElement('div');
                this.overlay.className = 'tutorial-overlay';
                document.body.appendChild(this.overlay);
                
                this.createTutorialBox();
                this.start();
            },
            
            createTutorialBox: function() {
                this.tutorialBox = document.createElement('div');
                this.tutorialBox.className = 'tutorial-box';
                document.body.appendChild(this.tutorialBox);
            },
            
            showStep: function(stepIndex) {
                const step = this.steps[stepIndex];
                if (!step) return;
                
                this.removeHighlight();
                
                let buttonsHtml = '';
                if (stepIndex < this.steps.length - 1) {
                    if (step.trigger) {
                        buttonsHtml = '<button class="tutorial-skip">Izlaist</button>';
                    } else {
                        buttonsHtml = '<button class="tutorial-next">Nākamais ➜</button>';
                    }
                } else {
                    buttonsHtml = '<button class="tutorial-finish">Sākt spēli!</button>';
                }
                
                this.tutorialBox.innerHTML = '<h4>' + step.title + '</h4><p>' + step.text + '</p>' + buttonsHtml;
                
                const nextBtn = this.tutorialBox.querySelector('.tutorial-next');
                const finishBtn = this.tutorialBox.querySelector('.tutorial-finish');
                const skipBtn = this.tutorialBox.querySelector('.tutorial-skip');
                const self = this;
                
                if (nextBtn) {
                    nextBtn.addEventListener('click', function() { self.nextStep(); });
                }
                if (finishBtn) {
                    finishBtn.addEventListener('click', function() { self.end(); });
                }
                if (skipBtn) {
                    skipBtn.addEventListener('click', function() { 
                        self.currentStep = self.steps.length - 1;
                        self.nextStep();
                    });
                }
                
                if (step.highlightSelector) {
                    const element = document.querySelector(step.highlightSelector);
                    if (element) {
                        this.highlightElement(element);
                        this.positionBox(element, step.position);
                    } else {
                        this.positionBox(null, 'center');
                        if (step.trigger) {
                            this.waitForElement(step.highlightSelector, step.position);
                        }
                    }
                } else {
                    this.positionBox(null, step.position);
                }
            },
            
            waitForElement: function(selector, position) {
                const self = this;
                let attempts = 0;
                const checkInterval = setInterval(function() {
                    attempts++;
                    const element = document.querySelector(selector);
                    if (element) {
                        clearInterval(checkInterval);
                        self.highlightElement(element);
                        self.positionBox(element, position);
                    } else if (attempts > 50) {
                        clearInterval(checkInterval);
                    }
                }, 100);
            },
            
            highlightElement: function(element) {
                this.removeHighlight();
                this.highlightedElement = element;
                element.classList.add('tutorial-highlight');
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
            },
        
            removeHighlight: function() {
                if (this.highlightedElement) {
                    this.highlightedElement.classList.remove('tutorial-highlight');
                    this.highlightedElement = null;
                }
            },
            
            positionBox: function(targetElement, position) {
                if (!this.tutorialBox) return;
                
                this.tutorialBox.style.display = 'block';
                
                if (!targetElement || position === 'center') {
                    this.tutorialBox.style.position = 'fixed';
                    this.tutorialBox.style.top = '50%';
                    this.tutorialBox.style.left = '50%';
                    this.tutorialBox.style.transform = 'translate(-50%, -50%)';
                    this.removeArrow();
                    return;
                }
                
                const rect = targetElement.getBoundingClientRect();
                const boxRect = this.tutorialBox.getBoundingClientRect();
                const spacing = 15;
                
                this.tutorialBox.style.position = 'fixed';
                this.tutorialBox.style.transform = 'none';
                
                switch(position) {
                    case 'top':
                        if (rect.top - boxRect.height - spacing > 0) {
                            this.tutorialBox.style.bottom = window.innerHeight - rect.top + spacing + 'px';
                        } else {
                            this.tutorialBox.style.top = rect.bottom + spacing + 'px';
                            position = 'bottom';
                        }
                        this.tutorialBox.style.left = Math.max(10, Math.min(rect.left + (rect.width / 2) - (boxRect.width / 2), window.innerWidth - boxRect.width - 10)) + 'px';
                        this.addArrow(position === 'top' ? 'bottom' : 'top', rect);
                        break;
                    case 'bottom':
                        if (rect.bottom + boxRect.height + spacing < window.innerHeight) {
                            this.tutorialBox.style.top = rect.bottom + spacing + 'px';
                        } else {
                            this.tutorialBox.style.bottom = window.innerHeight - rect.top + spacing + 'px';
                            position = 'top';
                        }
                        this.tutorialBox.style.left = Math.max(10, Math.min(rect.left + (rect.width / 2) - (boxRect.width / 2), window.innerWidth - boxRect.width - 10)) + 'px';
                        this.addArrow(position === 'bottom' ? 'top' : 'bottom', rect);
                        break;
                    case 'left':
                    case 'right':
                        const isRight = position === 'right';
                        if ((isRight && rect.right + boxRect.width + spacing < window.innerWidth) ||
                            (!isRight && rect.left - boxRect.width - spacing > 0)) {
                            if (isRight) {
                                this.tutorialBox.style.left = rect.right + spacing + 'px';
                            } else {
                                this.tutorialBox.style.right = window.innerWidth - rect.left + spacing + 'px';
                            }
                        } else {
                            if (isRight) {
                                this.tutorialBox.style.right = window.innerWidth - rect.left + spacing + 'px';
                            } else {
                                this.tutorialBox.style.left = rect.right + spacing + 'px';
                            }
                            position = isRight ? 'left' : 'right';
                        }
                        this.tutorialBox.style.top = Math.max(10, Math.min(rect.top + (rect.height / 2) - (boxRect.height / 2), window.innerHeight - boxRect.height - 10)) + 'px';
                        this.addArrow(position === 'right' ? 'left' : 'right', rect);
                        break;
                }
            },
            
            addArrow: function(direction, targetRect) {
                this.removeArrow();
                const arrow = document.createElement('div');
                arrow.className = 'tutorial-arrow ' + direction;
                this.tutorialBox.appendChild(arrow);
            },
            
            removeArrow: function() {
                const existingArrow = this.tutorialBox.querySelector('.tutorial-arrow');
                if (existingArrow) existingArrow.remove();
            },
            
            trigger: function(triggerName) {
                if (!this.isActive) return;
                
                const currentStep = this.steps[this.currentStep];
                if (currentStep && currentStep.trigger === triggerName && !this.stepsCompleted[this.currentStep]) {
                    this.stepsCompleted[this.currentStep] = true;
                    this.currentStep++;
                    if (this.currentStep >= this.steps.length) {
                        this.end();
                    } else {
                        this.showStep(this.currentStep);
                    }
                }
            },
            
            nextStep: function() {
                if (this.currentStep < this.steps.length - 1) {
                    this.currentStep++;
                    this.showStep(this.currentStep);
                } else {
                    this.end();
                }
            },
            
            start: function() {
                this.currentStep = 0;
                this.stepsCompleted = [];
                this.showStep(0);
            },
            
            end: function() {
                this.isActive = false;
                if (this.overlay) this.overlay.remove();
                if (this.tutorialBox) this.tutorialBox.remove();
                this.removeHighlight();

                document.querySelectorAll('.floating-tip').forEach(function(tip) {
                    tip.remove();
                });
                
            }
        };
        
        document.addEventListener('DOMContentLoaded', function() {
            TutorialSystem.init();
            
            const wrappers = document.querySelectorAll('.evidence-img-wrapper');
            const imageModalEl = document.getElementById('imageModal');
            const imageModal = new bootstrap.Modal(imageModalEl);
            const modalImg = document.getElementById('modalImage');
            
            let currentKeyArea = null;
            let currentImg = null;
            let currentWrapper = null;
            
            wrappers.forEach(function(wrapper) {
                const img = wrapper.querySelector('.evidence-img');
                let keyArea = null;
                
                if (img.dataset.keyArea && img.dataset.keyArea !== 'null' && img.dataset.keyArea !== '') {
                    try {
                        keyArea = JSON.parse(img.dataset.keyArea);
                    } catch (e) {
                        console.error('Invalid key area data:', img.dataset.keyArea);
                    }
                }
                
                wrapper.addEventListener('click', function(e) {
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
                        addScore(20);
                        let questionsUsed = askedQuestions.size;
                        updateProgress(opened, questionsUsed);
                        
                        TutorialSystem.trigger('hidden_object');
                        
                        if (opened >= 2) {
                            TutorialSystem.trigger('evidence_count_2');
                            document.querySelectorAll('.locked-question').forEach(function(q) { q.classList.remove('d-none'); });
                            document.querySelectorAll('.question-buttons').forEach(function(q) { q.style.display = 'flex'; });
                            document.querySelectorAll('.question-message').forEach(function(m) { m.classList.add('d-none'); });
                            document.querySelectorAll('.msg').forEach(function(m) { m.classList.remove('d-none'); });
                        }
                        
                        if (submitBtn) submitBtn.disabled = opened < 2;
                        
                        showSmallNotification('Pierādījums atrasts! +20 punkti', 'success');
                        
                        setTimeout(function() {
                            imageModal.hide();
                        }, 1500);
                    } else {
                        showSmallNotification('Jūs jau atradāt šo pierādījumu!', 'warning');
                    }
                }
            }
            
            imageModalEl.addEventListener('hidden.bs.modal', function() {
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
            const askedQuestions = new Set();
            let score = 0;
            
            function addScore(points) {
                score += points;
                const scoreInput = document.getElementById('scoreInput');
                const scoreDisplay = document.getElementById('scoreDisplay');
                if (scoreInput) scoreInput.value = score;
                if (scoreDisplay) scoreDisplay.innerText = 'Punkti: ' + score;
            }
            
            buttons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    TutorialSystem.trigger('evidence_click');
                    
                    const content = btn.nextElementSibling;
                    const isHidden = content.classList.contains('d-none');
                    
                    if (isHidden) {
                        content.classList.remove('d-none');
                        btn.textContent = 'Paslēpt';
                        
                        const img = content.querySelector('.evidence-img');
                        let hasKeyArea = false;
                        
                        if (img && img.dataset.keyArea && img.dataset.keyArea !== 'null' && img.dataset.keyArea !== '') {
                            try {
                                const keyArea = JSON.parse(img.dataset.keyArea);
                                hasKeyArea = keyArea && typeof keyArea.x === 'number';
                            } catch (e) {
                                console.error('Invalid key area data:', img.dataset.keyArea);
                            }
                        }
                        
                        if (!hasKeyArea && !content.dataset.counted) {
                            content.dataset.counted = 'true';
                            addScore(15);
                            
                            let opened = parseInt(openedInput.value) || 0;
                            opened++;
                            openedInput.value = opened;
                            let questionsUsed = askedQuestions.size;
                            updateProgress(opened, questionsUsed);
                            
                            if (opened >= 2) {
                                TutorialSystem.trigger('evidence_count_2');
                                document.querySelectorAll('.locked-question').forEach(function(q) { q.classList.remove('d-none'); });
                                document.querySelectorAll('.question-buttons').forEach(function(q) { q.style.display = 'flex'; });
                                document.querySelectorAll('.question-message').forEach(function(m) { m.classList.add('d-none'); });
                                document.querySelectorAll('.msg').forEach(function(m) { m.classList.remove('d-none'); });
                            }
                            
                            if (submitBtn) submitBtn.disabled = opened < 2;
                            
                            showSmallNotification('Pierādījums atvērts! +15 punkti', 'success');
                        } else if (hasKeyArea) {
                            showSmallNotification('Šeit ir slēpta vieta! Atrodi to!', 'info');
                        }
                    } else {
                        content.classList.add('d-none');
                        btn.textContent = 'Atvērt pierādījumu';
                    }
                });
            });
            
            document.querySelectorAll('.ask-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    TutorialSystem.trigger('ask_question');
                    
                    const allAnswers = btn.closest('.questions').querySelectorAll('.answer');
                    allAnswers.forEach(function(a) { a.classList.add('d-none'); });
                    
                    const answer = btn.nextElementSibling;
                    answer.classList.remove('d-none');
                    
                    const questionText = btn.textContent.trim();
                    
                    if (!askedQuestions.has(questionText)) {
                        askedQuestions.add(questionText);
                        addScore(10);
                        showSmallNotification('Jautājums uzdots! +10 punkti', 'success');
                        
                        let opened = parseInt(openedInput.value) || 0;
                        let questionsUsed = askedQuestions.size;
                        updateProgress(opened, questionsUsed);
                    }
                    
                    answer.style.opacity = '0';
                    answer.style.transition = 'opacity 0.3s ease';
                    setTimeout(function() {
                        answer.style.opacity = '1';
                    }, 10);
                });
            });
            
            const suspectCards = document.querySelectorAll('.suspect-card');
            const selectedInput = document.getElementById('selectedSuspectId');
            
            suspectCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    TutorialSystem.trigger('select_suspect');
                    
                    suspectCards.forEach(function(c) { c.classList.remove('border-warning'); });
                    card.classList.add('border-warning');
                    if (selectedInput) {
                        selectedInput.value = card.dataset.suspectId;
                    }
                });
            });
            
            const slides = document.querySelectorAll('.suspect-slide');
            let current = 0;
            
            const showSlide = function(index) {
                slides.forEach(function(s, i) {
                    s.classList.toggle('d-none', i !== index);
                });
            };
            
            const prevBtn = document.getElementById('prevSuspect');
            const nextBtn = document.getElementById('nextSuspect');
            
            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', function() {
                    current = (current - 1 + slides.length) % slides.length;
                    showSlide(current);
                });
                
                nextBtn.addEventListener('click', function() {
                    current = (current + 1) % slides.length;
                    showSlide(current);
                });
            }
            
            const cards = document.querySelectorAll('.suspect-card');
            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.questions').forEach(function(q) { q.classList.add('d-none'); });
                    const questions = card.querySelector('.questions');
                    if (questions) questions.classList.remove('d-none');
                });
            });
            
            function updateProgress(opened, questionsUsed) {
                if (questionsUsed === undefined) questionsUsed = 0;
                const totalEvidence = {{ count($evidence) }};
                const totalQuestions = {{ count($questions) }};
                const token = document.querySelector('input[name="_token"]');
                
                const total = totalEvidence + totalQuestions;
                const completed = opened + questionsUsed;
                
                let percent = total > 0 ? (completed / total) * 100 : 0;
                percent = Math.min(percent, 100);
                
                const bar = document.querySelector('.progress-bar');
                
                if (bar) {
                    bar.style.width = percent + '%';
                    bar.innerText = Math.round(percent) + '%';
                }
                
                if (!token) return;
                
                fetch('/progress/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token.value
                    },
                    body: JSON.stringify({
                        case_id: {{ json_encode($case->id) }},
                        opened_evidence: opened,
                        questions_used: questionsUsed,
                        score: document.getElementById('scoreInput')?.value || 0
                    })
                }).catch(function(err) { console.error('Progress update error:', err); });
            }
        });

        function showSmallNotification(message, type) {
            if (type === undefined) type = 'info';

            const oldNotifs = document.querySelectorAll('.evidence-notification');
            oldNotifs.forEach(function(notif) {
                notif.remove();
            });
            
            const notif = document.createElement('div');
            notif.className = 'evidence-notification ' + type;
            notif.innerHTML = message;
            document.body.appendChild(notif);
            
            setTimeout(function() { 
                notif.classList.add('show'); 
            }, 10);
            
            setTimeout(function() {
                notif.classList.remove('show');
                setTimeout(function() { 
                    if (notif && notif.remove) notif.remove(); 
                }, 300);
            }, 2000);
        }
    </script>

<script>
    (function() {
        let isSearchMode = false;
        let originalCursor = '';
        
        function disableHighlightForSearch() {
            if (!isSearchMode) return;

            const highlightedElements = document.querySelectorAll('.tutorial-highlight');
            
            highlightedElements.forEach(function(el) {
                el.dataset.wasHighlighted = 'true';
                el.classList.remove('tutorial-highlight');
            });
        }
        
        function restoreHighlightAfterSearch() {
            if (!isSearchMode) return;

            const elements = document.querySelectorAll('[data-was-highlighted="true"]');
            elements.forEach(function(el) {
                el.classList.add('tutorial-highlight');
                delete el.dataset.wasHighlighted;
            });
        }

        const imageModal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        
        if (imageModal && modalImg) {
            imageModal.addEventListener('show.bs.modal', function() {)
                const hasKeyArea = modalImg.src && 
                    document.querySelector('.evidence-img[src="' + modalImg.src + '"]')?.dataset.keyArea;
                
                if (hasKeyArea && hasKeyArea !== 'null' && hasKeyArea !== '') {
                    isSearchMode = true;
                    disableHighlightForSearch();
                }
            });
            
            imageModal.addEventListener('hidden.bs.modal', function() {
                if (isSearchMode) {
                    isSearchMode = false;
                    restoreHighlightAfterSearch();
                }
            });
        }
        
        const wrappers = document.querySelectorAll('.evidence-img-wrapper');
        wrappers.forEach(function(wrapper) {
            wrapper.addEventListener('click', function() {
                const img = wrapper.querySelector('.evidence-img');
                if (img && img.dataset.keyArea && img.dataset.keyArea !== 'null' && img.dataset.keyArea !== '') {
                }
            });
        });

        window.TutorialHighlight = {
            disable: function() {
                const highlighted = document.querySelectorAll('.tutorial-highlight');
                highlighted.forEach(function(el) {
                    if (!el.dataset.savedHighlight) {
                        el.dataset.savedHighlight = 'true';
                        el.classList.remove('tutorial-highlight');
                    }
                });
            },
            
            enable: function() {
                const saved = document.querySelectorAll('[data-saved-highlight="true"]');
                saved.forEach(function(el) {
                    el.classList.add('tutorial-highlight');
                    delete el.dataset.savedHighlight;
                });
            },

            isSearchModeActive: function() {
                return isSearchMode;
            }
        };
    })();
</script>

<script>
    (function() {
        let isSearchMode = false;
        let originalCursor = '';
        
        function disableHighlightForSearch() {
            if (!isSearchMode) return;
            
            const highlightedElements = document.querySelectorAll('.tutorial-highlight');

            highlightedElements.forEach(function(el) {
                el.dataset.wasHighlighted = 'true';
                el.classList.remove('tutorial-highlight');
            });
        }
        
        function restoreHighlightAfterSearch() {
            if (!isSearchMode) return;
            
            const elements = document.querySelectorAll('[data-was-highlighted="true"]');
            elements.forEach(function(el) {
                el.classList.add('tutorial-highlight');
                delete el.dataset.wasHighlighted;
            });
        }
        
        const imageModal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        
        if (imageModal && modalImg) {
            imageModal.addEventListener('show.bs.modal', function() {
                const hasKeyArea = modalImg.src && 
                    document.querySelector('.evidence-img[src="' + modalImg.src + '"]')?.dataset.keyArea;
                
                if (hasKeyArea && hasKeyArea !== 'null' && hasKeyArea !== '') {
                    isSearchMode = true;
                    disableHighlightForSearch();
                }
            });
            
            imageModal.addEventListener('hidden.bs.modal', function() {
                if (isSearchMode) {
                    isSearchMode = false;
                    restoreHighlightAfterSearch();
                }
            });
        }

        const wrappers = document.querySelectorAll('.evidence-img-wrapper');
        wrappers.forEach(function(wrapper) {
            wrapper.addEventListener('click', function() {
                const img = wrapper.querySelector('.evidence-img');
                if (img && img.dataset.keyArea && img.dataset.keyArea !== 'null' && img.dataset.keyArea !== '') {
                }
            });
        });
        
        window.TutorialHighlight = {
            disable: function() {
                const highlighted = document.querySelectorAll('.tutorial-highlight');
                highlighted.forEach(function(el) {
                    if (!el.dataset.savedHighlight) {
                        el.dataset.savedHighlight = 'true';
                        el.classList.remove('tutorial-highlight');
                    }
                });
            },
            
            enable: function() {
                const saved = document.querySelectorAll('[data-saved-highlight="true"]');
                saved.forEach(function(el) {
                    el.classList.add('tutorial-highlight');
                    delete el.dataset.savedHighlight;
                });
            },
            
            isSearchModeActive: function() {
                return isSearchMode;
            }
        };
    })();
</script>

    @include('partials.footer')
</body>

</html>