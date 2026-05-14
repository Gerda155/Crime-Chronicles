<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mani vērtējumi - Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            <i class="fa-solid fa-star me-2"></i>
            Mani vērtējumi
        </h1>

        {{-- ALERT --}}
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        {{-- LIST --}}
        <div class="row g-3">

            @forelse($ratings as $rating)

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

                        {{-- EDIT --}}
                        <button class="btn btn-sm btn-outline-warning rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#editRatingModal{{ $rating->id }}">
                            Rediģēt
                        </button>

                        {{-- DELETE --}}
                        <button class="btn btn-sm btn-outline-danger rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteRatingModal{{ $rating->id }}">
                            Dzēst
                        </button>

                    </div>

                </div>

            </div>

            <div class="modal fade" id="editRatingModal{{ $rating->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content bg-dark text-light border border-warning">

                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Rediģēt vērtējumu</h5>
                        </div>

                        <div class="modal-body text-center">

                            <form action="{{ route('ratings.update', $rating->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- STARS --}}
                                <div class="mb-3 rating-stars d-flex justify-content-center gap-1" style="font-size:2rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="star"
                                        data-value="{{ $i }}"
                                        style="cursor:pointer; color: {{ $i <= $rating->rating ? '#ffc107' : '#555' }};">
                                        <input type="radio"
                                            name="rating"
                                            value="{{ $i }}"
                                            style="display:none;"
                                            {{ $i == $rating->rating ? 'checked' : '' }}>
                                        &#9733;
                                        </label>
                                        @endfor
                                </div>

                                {{-- COMMENT --}}
                                <textarea name="comment"
                                    class="form-control mb-3 bg-secondary text-light border-0"
                                    placeholder="Komentārs...">{{ $rating->comment }}</textarea>

                                <button type="submit" class="btn btn-warning w-100">
                                    Saglabāt
                                </button>

                            </form>

                        </div>

                    </div>

                </div>
            </div>

            <div class="modal fade" id="deleteRatingModal{{ $rating->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content bg-dark text-light border border-danger">

                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title text-danger">
                                Apstiprināt dzēšanu
                            </h5>
                        </div>

                        <div class="modal-body text-center">
                            Vai tiešām vēlies dzēst šo vērtējumu?
                            <br>
                            <span class="text-warning">Šo darbību nevar atcelt.</span>
                        </div>

                        <div class="modal-footer border-top-0">

                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                Atcelt
                            </button>

                            <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    Dzēst
                                </button>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
            @empty

            <div class="text-center text-secondary py-5">
                <i class="fa-solid fa-star fa-3x mb-3 d-block"></i>
                Nav vērtējumu
            </div>

            @endforelse

        </div>

    </main>

    <script>
        document.querySelectorAll('.rating-stars .star').forEach(star => {
            star.addEventListener('click', function() {
                let value = this.dataset.value;
                let parent = this.parentElement;

                parent.querySelectorAll('.star').forEach(s => {
                    s.style.color = '#555';
                });

                for (let i = 0; i < value; i++) {
                    parent.querySelectorAll('.star')[i].style.color = '#ffc107';
                }
            });
        });
    </script>

    @include('partials.footer')

</body>

</html>