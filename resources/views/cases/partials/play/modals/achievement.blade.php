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
@endif