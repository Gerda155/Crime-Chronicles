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