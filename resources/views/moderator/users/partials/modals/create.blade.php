@if(Auth::user()->role === 'admin')

<div class="modal fade" id="addModeratorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">

            <div class="modal-header">
                <h5 class="modal-title">Moderatora pievienošana</h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.moderators.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Lietotājvārds</label>
                        <input type="text" name="username"
                            class="form-control bg-secondary text-light border-0"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-pasts</label>
                        <input type="email" name="email"
                            class="form-control bg-secondary text-light border-0"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vārds</label>
                        <input type="text" name="name"
                            class="form-control bg-secondary text-light border-0"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parole</label>
                        <input type="password" name="password"
                            class="form-control bg-secondary text-light border-0"
                            required minlength="8">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apstiprināt paroli</label>
                        <input type="password" name="password_confirmation"
                            class="form-control bg-secondary text-light border-0"
                            required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Pievienot</button>

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Aizvērt
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endif
