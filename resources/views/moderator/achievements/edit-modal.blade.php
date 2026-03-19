<div class="modal fade" id="editAchievementModal{{ $achievement->id }}" tabindex="-1" aria-hidden="true">
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
                <h5 class="modal-title">Rediģēt sasniegumu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('moderator.achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nosaukums</label>
                        <input type="text" name="title" class="form-control bg-secondary text-light border-0" value="{{ $achievement->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apraksts</label>
                        <textarea name="description" class="form-control bg-secondary text-light border-0" required>{{ $achievement->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nosacījums (pabeigto lietu skaits)</label>
                        <input type="number" name="required_cases" class="form-control bg-secondary text-light border-0" min="1" value="{{ $achievement->required_cases }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ikona</label>
                        <input type="file" name="icon" class="form-control bg-secondary text-light border-0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success rounded">Atjaunināt</button>
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Aizvērt</button>
                </div>
            </form>
        </div>
    </div>
</div>
