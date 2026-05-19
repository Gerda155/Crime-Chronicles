<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">

            <div class="modal-header">
                <h5 class="modal-title">Apstiprināt dzēšanu</h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Vai tiešām dzēst šo ierakstu?
            </div>

            <div class="modal-footer">

                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Atcelt
                </button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Dzēst
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const deleteModal = document.getElementById('deleteModal');
        if (!deleteModal) return;
        deleteModal.addEventListener('show.bs.modal', function(event) {

            const button = event.relatedTarget;
            if (!button) return;
            const action = button.getAttribute('data-action');
            const form = deleteModal.querySelector('#deleteForm');
            if (form && action) {
                form.action = action;
            }
        });
    });
</script>