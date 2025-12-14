<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visas lietas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <nav class="navbar navbar-dark px-4">
        <div class="ms-auto">
            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Pieteikties</a>
            <a href="{{ route('register') }}" class="btn btn-light">Reģistrēties</a>
            @endguest
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="mb-4 text-center">Visas lietas</h1>

        <form id="casesForm" method="GET" action="{{ route('cases.index') }}" class="row g-3 mb-4">
            <div class="col-md-6">
                <input id="searchInput" type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Meklēt pēc nosaukuma...">
            </div>
            <div class="col-md-6">
                <select id="sortSelect" name="sort" class="form-select">
                    <option value="">Kārtot pēc...</option>
                    <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Jaunākie</option>
                    <option value="oldest" {{ request('sort')=='oldest'?'selected':'' }}>Vecākie</option>
                    <option value="rating" {{ request('sort')=='rating'?'selected':'' }}>Reitings</option>
                    <option value="title" {{ request('sort')=='title'?'selected':'' }}>Nosaukums</option>
                    <option value="genre" {{ request('sort')=='genre'?'selected':'' }}>Žanrs</option>
                </select>
            </div>
        </form>


        <div class="row g-4" id="casesContainer">
            @foreach($cases as $case)
            <div class="col-md-6 col-lg-4 case-card">
                <div class="card p-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">{{ $case->title }}</h5>
                    </div>

                    <p class="card-text">
                        {{ Str::limit($case->description, 100, '...') }}
                    </p>

                    <ul class="list-unstyled mb-0">
                        <li><strong>Žanrs:</strong> {{ $case->genre->name ?? '-' }}</li>
                        <li><strong>Reitings:</strong> {{ $case->rating }}</li>
                        <li><strong>Izveidots:</strong> {{ $case->created_at->format('d.m.Y') }}</li>
                    </ul>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $cases->links('vendor.pagination.custom') }}
        </div>

        <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="authModalLabel">Uzmanību!</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

</body>

</html>