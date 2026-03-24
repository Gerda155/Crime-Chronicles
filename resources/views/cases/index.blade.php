<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visas lietas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    @include('partials.header')
    @include('partials.burger')

    <div class=" container my-5">
        <h1 class="text-center mb-4">Visas lietas</h1>

        <div class="d-flex flex-wrap gap-2 mb-4">

            <form method="GET" action="{{ route('cases.index') }}" class="d-flex gap-2 flex-grow-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control bg-secondary text-light border-0 rounded"
                    placeholder="Meklēt pēc nosaukuma">

                <input type="hidden" name="sort" value="{{ request('sort') }}">

                <button type="submit" class="btn btn-primary rounded">Meklēt</button>
            </form>

            <form method="GET" action="{{ route('cases.index') }}" class="d-flex gap-2">
                <select name="sort" class="form-select bg-secondary text-light border-0 rounded">
                    <option value="">Kārtot pēc...</option>
                    <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Jaunākie</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Vecākie</option>
                    <option value="rating" {{ request('sort')=='rating' ? 'selected' : '' }}>Reitings</option>
                    <option value="title" {{ request('sort')=='title' ? 'selected' : '' }}>Nosaukums</option>
                    <option value="genre" {{ request('sort')=='genre' ? 'selected' : '' }}>Žanrs</option>
                </select>

                <input type="hidden" name="search" value="{{ request('search') }}">

                <button type="submit" class="btn btn-primary rounded">Kārtot</button>
            </form>

        </div>

        <div class="row g-4">
            @forelse($cases as $case)
            <div class="col-md-6 col-lg-4">
                <div class="card p-3 h-100"
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


            @auth
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

            @endauth

            @empty
            <div class="col-12 text-center text-secondary my-5">
                <p>Nav nevienas aktīvas lietas, kas atbilst meklēšanas kritērijiem.</p>
            </div>
            @endforelse
        </div>


        <div class="mt-4">
            {{ $cases->links() }}
        </div>
    </div>

    {{-- GUEST MODAL --}}
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
    @include('partials.footer')

</body>

</html>