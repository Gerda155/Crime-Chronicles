
@foreach($rangs as $rang)
<div class="modal fade" id="editRankModal{{ $rang->id }}" tabindex="-1" aria-labelledby="editRankModalLabel{{ $rang->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="editRankModalLabel{{ $rang->id }}">Rediģēt rangu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('moderator.rangs.update', $rang->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @if($errors->any() && old('_method') == 'PUT')
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <input type="hidden" name="modal_id" value="editRankModal{{ $rang->id }}">

                    <div class="mb-3">
                        <label class="form-label">Nosaukums</label>
                        <input type="text" name="name"
                            class="form-control bg-secondary text-light border-0"
                            value="{{ $rang->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Min punkti</label>
                        <input type="number" name="min_score"
                            class="form-control bg-secondary text-light border-0"
                            value="{{ $rang->min_score }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Max punkti</label>
                        <input type="number" name="max_score"
                            class="form-control bg-secondary text-light border-0"
                            value="{{ $rang->max_score }}">
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
@endforeach