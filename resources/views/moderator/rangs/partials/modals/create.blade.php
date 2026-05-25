<div class="modal fade" id="createRankModal" tabindex="-1" aria-labelledby="createRankModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="createRankModalLabel">Izveidot jaunu rangu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="createRankForm" action="{{ route('moderator.rangs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <input type="hidden" name="modal_id" value="createRankModal">

                    <div class="mb-3">
                        <label class="form-label">Nosaukums</label>
                        <input type="text" name="name" id="create_name"
                            class="form-control bg-secondary text-light border-0"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Min punkti</label>
                        <input type="number" name="min_score" id="create_min_score"
                            class="form-control bg-secondary text-light border-0"
                            value="{{ old('min_score') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Max punkti</label>
                        <input type="number" name="max_score" id="create_max_score"
                            class="form-control bg-secondary text-light border-0"
                            value="{{ old('max_score') }}">
                        <small class="text-muted">Atstāj tukšu, ja nav augšējās robežas</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success rounded">Saglabāt</button>
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Aizvērt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createModal = document.getElementById('createRankModal');
        const createForm = document.getElementById('createRankForm');

        if (createModal && createForm) {
            createModal.addEventListener('hidden.bs.modal', function() {
                createForm.reset();
                createForm.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                const errorAlert = createForm.querySelector('.alert-danger');
                if (errorAlert) {
                    errorAlert.remove();
                }
            });
        }
    });
</script>

