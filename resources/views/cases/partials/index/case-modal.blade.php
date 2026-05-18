<div class="modal fade" id="caseModal-{{ $case->id }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title">{{ $case->title }}</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{ $case->description }}</p>
                <ul class="list-unstyled">
                    <li><strong>Žanrs:</strong> {{ $case->genre->name ?? '-' }}</li>
                    <li><strong>Reitings:</strong> {{ $case->rating }}</li>
                    <li><strong>Izveidots:</strong> {{ $case->created_at->format('d.m.Y') }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="{{ route('cases.play', $case->id) }}" class="btn btn-success">Sākt izmeklēšanu</a>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Aizvērt</button>
            </div>
        </div>
    </div>
</div>