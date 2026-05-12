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
@endif