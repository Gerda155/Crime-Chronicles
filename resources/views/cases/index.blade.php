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

    {{-- HEADER --}}
    <nav class="navbar navbar-dark px-4 d-flex justify-content-between">
        <div>
            @auth
            <button class="btn btn-outline-light" data-bs-toggle="offcanvas" data-bs-target="#burgerMenu">
                ☰
            </button>
            @endauth
        </div>

        <div class="d-flex align-items-center gap-3">
            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light">Pieteikties</a>
            <a href="{{ route('register') }}" class="btn btn-light">Reģistrēties</a>
            @endguest

            @auth
            <img
                src="{{ Auth::user()->avatar
                    ? asset('storage/' . Auth::user()->avatar)
                    : asset('images/avatar-placeholder.jpg') }}"
                class="rounded-circle"
                width="40"
                height="40"
                style="object-fit: cover;">

            <span class="text-light">
                Sveiki, {{ Auth::user()->name }}!
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">Iziet</button>
            </form>
            @endauth
        </div>
    </nav>

    {{-- BURGER --}}
    @auth
    <div class="offcanvas offcanvas-start text-bg-dark" id="burgerMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Izvēlne</h5>
            <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <a href="{{ route('cases.index') }}" class="d-block text-light mb-2">
                Visas lietas
            </a>
        </div>
        <a href="{{ route('profile.edit') }}"">Mans profils</a>

</div>
@endauth

{{-- CONTENT --}}
<div class=" container my-5">
            <h1 class="text-center mb-4">Visas lietas</h1>

            {{-- FILTERS --}}
            <form method="GET" action="{{ route('cases.index') }}" class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Meklēt pēc nosaukuma..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-6">
                    <select name="sort" class="form-select">
                        <option value="">Kārtot pēc...</option>
                        <option value="newest" @selected(request('sort')==='newest' )>Jaunākie</option>
                        <option value="oldest" @selected(request('sort')==='oldest' )>Vecākie</option>
                        <option value="rating" @selected(request('sort')==='rating' )>Reitings</option>
                        <option value="title" @selected(request('sort')==='title' )>Nosaukums</option>
                        <option value="genre" @selected(request('sort')==='genre' )>Žanrs</option>
                    </select>
                </div>
            </form>

            {{-- CASES --}}
            <div class="row g-4">
                @foreach($cases as $case)
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

                {{-- AUTH MODAL --}}
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
                                <a href="" class="btn btn-success">
                                    Sākt izmeklēšanu
                                </a>
                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                    Aizvērt
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @endauth
                @endforeach
            </div>

            <div class="mt-4">
                {{ $cases->links('vendor.pagination.custom') }}
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

</body>

</html>