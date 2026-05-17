<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">
                    <i class="fa-solid fa-circle-xmark text-danger me-2"></i>
                    Noraidīt lietu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="rejectForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <label class="form-label">Noraidījuma iemesls</label>
                    <textarea name="reason" rows="4" class="form-control bg-secondary text-light border-0"
                        placeholder="Ievadi iemeslu..." required></textarea>
                    <small class="text-light-50 mt-2 d-block">
                        <i class="fa-solid fa-info-circle"></i>
                        Šis iemesls tiks nosūtīts lietas autoram
                    </small>
                </div>

                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Atcelt</button>
                    <button type="submit" class="btn btn-danger rounded">Noraidīt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
rejectModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    if (!button) return;

    const action = button.getAttribute('data-action');

    const form = document.getElementById('rejectForm');

    form.setAttribute('action', action);
});
</script>