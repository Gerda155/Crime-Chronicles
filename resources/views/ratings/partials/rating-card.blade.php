<div class="col-md-6">

    <div class="card bg-dark text-light border-secondary h-100 p-3">

        <h5 class="fw-bold mb-2">
            {{ $rating->case->title ?? 'Lieta' }}
        </h5>

        <div class="mb-2">
            @for($i = 1; $i <= 5; $i++)
                @if($i <=$rating->rating)
                <i class="fa-solid fa-star text-warning"></i>
                @else
                <i class="fa-regular fa-star text-secondary"></i>
                @endif
                @endfor
                <span class="ms-2 text-secondary">{{ $rating->rating }}/5</span>
        </div>

        <p class="text-light">
            {{ $rating->comment }}
        </p>

        <small class="text-secondary">
            {{ $rating->created_at->format('d.m.Y H:i') }}
        </small>

        <div class="mt-3 d-flex gap-2">

            <button class="btn btn-sm btn-outline-warning rounded"
                data-bs-toggle="modal"
                data-bs-target="#editRatingModal{{ $rating->id }}">
                Rediģēt
            </button>

            <button class="btn btn-sm btn-outline-danger rounded"
                data-bs-toggle="modal"
                data-bs-target="#deleteRatingModal{{ $rating->id }}">
                Dzēst
            </button>
        </div>
    </div>
</div>