@if(Auth::user()->role === 'admin')
<div class="modal fade" id="addModeratorModal" tabindex="-1" aria-labelledby="addModeratorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="addModeratorModalLabel">Moderatora pievienošanas forma</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.moderators.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Lietotājvārds</label>
                        <input type="text" name="username" class="form-control bg-secondary text-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-pasts</label>
                        <input type="email" name="email" class="form-control bg-secondary text-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Vārds</label>
                        <input type="text" name="name" class="form-control bg-secondary text-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Parole</label>
                        <input type="password" name="password" class="form-control bg-secondary text-light border-0" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Apstiprināt paroli</label>
                        <input type="password" name="password_confirmation" class="form-control bg-secondary text-light border-0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success rounded">Pievienot</button>
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Aizvērt</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Apstiprināt dzēšanu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Vai tiešām vēlies dzēst šo ierakstu? Šī darbība ir neatgriezeniska!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Atcelt</button>
                <form id="deleteForm" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded">Dzēst</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            const form = deleteModal.querySelector('#deleteForm');
            form.action = action;
        });
    });
</script>