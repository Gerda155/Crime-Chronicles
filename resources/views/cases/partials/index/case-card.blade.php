<div class="col-md-6 col-lg-4 card-hover">
    <div class="card p-3 h-100 "
        data-bs-toggle="modal"
        data-bs-target="@auth #caseModal-{{ $case->id }} @else #authModal @endauth">

        <h5 class="card-title">{{ $case->title }}</h5>

        <p class="card-text">
            {{ Str::limit($case->description, 100) }}
        </p>

        <ul class="list-unstyled mb-0">
            <li><strong>Žanrs:</strong> {{ $case->genre->name ?? '-' }}</li>
            <li><strong>Reitings:</strong> {{ $case->rating }}</li>
            <li><strong>Izveidots:</strong> {{ $case->created_at->format('d.m.Y') }}</li>
        </ul>
    </div>
</div>