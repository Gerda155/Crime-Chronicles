<div class="modal fade" id="editGenreModal{{ $genre->id }}" tabindex="-1" aria-labelledby="editGenreModalLabel{{ $genre->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <div class="modal-header">
                <h5 class="modal-title" id="editGenreModalLabel{{ $genre->id }}">Žanra rediģēšanas forma</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('moderator.genres.update', $genre->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nosaukums</label>
                        <input type="text" name="name" class="form-control bg-secondary text-light border-0" value="{{ $genre->name }}" required>
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
