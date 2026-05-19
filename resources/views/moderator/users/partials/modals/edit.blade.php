@foreach($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-secondary">

            <div class="modal-header">
                <h5 class="modal-title">Rediģēt lietotāju</h5>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('admin.users.update', ['user' => $user->id]) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Vārds</label>
                        <input type="text"
                            name="name"
                            value="{{ $user->name }}"
                            class="form-control bg-secondary text-light border-0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role"
                            class="form-select bg-secondary text-light border-0">

                            <option value="user" @selected($user->role=='user')>User</option>
                            <option value="moderator" @selected($user->role=='moderator')>Moderator</option>
                            <option value="admin" @selected($user->role=='admin')>Admin</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select bg-secondary text-light border-0">
                            <option value="active" @selected($user->status=='active')>Aktīvs</option>
                            <option value="inactive" @selected($user->status=='inactive')>Neaktīvs</option>
                        </select>
                    </div>

                    </select>
                </div>


        <div class="modal-footer">
            <button class="btn btn-success">Saglabāt</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Aizvērt
            </button>
        </div>

        </form>

    </div>
</div>
</div>

@endforeach