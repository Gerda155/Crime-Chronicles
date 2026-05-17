<div class="modal fade" id="tutorialModal" tabindex="-1" aria-labelledby="tutorialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="tutorialModalLabel">Tutorial apstiprināšana</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Sistēmā vienlaicīgi var būt tikai viens tutorial.
                Vai tiešām vēlies šo lietu iestatīt kā tutorial?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">
                    Atcelt
                </button>

                <form id="tutorialForm" method="POST">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn btn-info rounded">
                        Apstiprināt
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tutorialModal = document.getElementById('tutorialModal');

    tutorialModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');

            const form = tutorialModal.querySelector('#tutorialForm');
            form.action = action;
        });
    });
</script>