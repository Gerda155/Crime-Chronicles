<div class="modal fade" id="authModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title">Uzmanību!</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Lai atklātu noziedznieku, Jums nepieciešams reģistrēties.
            </div>
            <div class="modal-footer">
                <a href="{{ route('login') }}" class="btn btn-danger">Pieteikties</a>
                <a href="{{ route('register') }}" class="btn btn-light">Reģistrēties</a>
            </div>
        </div>
    </div>
</div>