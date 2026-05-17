<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Genres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

    <h1 class="text-center mb-4 fw-bold">
        Moderatora panelis - Žanri
    </h1>

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-text">Kopā žanru</div>
                        <div class="card-title">{{ $genres->count() }}</div>
                    </div>

                    <i class="fa-solid fa-masks-theater card-title"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-text">Aktīvie</div>
                        <div class="card-title">
                            {{ $genres->where('status', 'active')->count() }}
                        </div>
                    </div>

                    <i class="fa-solid fa-circle-check card-title text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-text">Neaktīvie</div>
                        <div class="card-title">
                            {{ $genres->where('status', 'inactive')->count() }}
                        </div>
                    </div>

                    <i class="fa-solid fa-ban card-title text-danger"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-text">Pēdējais žanrs</div>

                        <div class="card-title fs-6">
                            {{ $genres->first()->name ?? 'Nav datu' }}
                        </div>
                    </div>

                    <i class="fa-solid fa-clock-rotate-left card-title text-warning"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">

        <form method="GET" class="d-flex gap-2 flex-grow-1">

            <span class="input-group-text bg-secondary border-0 text-light">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>

            <input type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control bg-secondary text-light border-0 rounded"
                placeholder="Meklēt pēc nosaukuma">

            <button type="submit" class="btn btn-primary rounded">
                Meklēt
            </button>

        </form>

        <form method="GET" class="d-flex gap-2">

            <select name="sort" class="form-select bg-secondary text-light border-0 rounded">

                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                    Jaunākie
                </option>

                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                    Vecākie
                </option>

                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                    Nosaukums A-Z
                </option>

                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                    Nosaukums Z-A
                </option>

                <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>
                    Aktīvie
                </option>

                <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>
                    Neaktīvie
                </option>

            </select>

            <button type="submit" class="btn btn-primary rounded">
                Kārtot
            </button>

        </form>

        <button class="btn btn-success rounded"
            data-bs-toggle="modal"
            data-bs-target="#createGenreModal">

            <i class="fa-solid fa-plus me-1"></i>
            Izveidot žanru
        </button>

    </div>

    {{-- УСПЕХ --}}
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ТАБЛИЦА --}}
    <div class="table-responsive rounded shadow-sm">

        <table class="table table-dark table-hover align-middle mb-0">

            <thead class="table-dark text-uppercase text-muted small">
                <tr>
                    <th>#</th>

                    <th>
                        <i class="fa-solid fa-masks-theater me-1"></i>
                        Nosaukums
                    </th>

                    <th>
                        <i class="fa-solid fa-toggle-on me-1"></i>
                        Statuss
                    </th>

                    <th>
                        <i class="fa-solid fa-calendar me-1"></i>
                        Izveidots
                    </th>

                    <th>
                        <i class="fa-solid fa-gear me-1"></i>
                        Darbības
                    </th>
                </tr>
            </thead>

            <tbody>

                @forelse($genres as $genre)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td class="fw-bold">
                        {{ $genre->name }}
                    </td>

                    <td>

                        @if($genre->status === 'active')

                        <span class="badge bg-success">
                            <i class="fa-solid fa-circle-check me-1"></i>
                            Aktīvs
                        </span>

                        @else

                        <span class="badge bg-danger">
                            <i class="fa-solid fa-ban me-1"></i>
                            Neaktīvs
                        </span>

                        @endif

                    </td>

                    <td>
                        <small>
                    
                        </small>
                    </td>

                    <td class="d-flex flex-wrap gap-1">

                        <button class="btn btn-sm btn-outline-primary rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#editGenreModal{{ $genre->id }}"
                            title="Rediģēt">

                            <i class="fa-solid fa-pen"></i>
                        </button>

                        @if($genre->deleted_at)

                        <form action="{{ route('moderator.genres.restore', $genre->id) }}"
                            method="POST">

                            @csrf

                            <button type="submit"
                                class="btn btn-sm btn-outline-success rounded"
                                title="Atjaunot">

                                <i class="fa-solid fa-rotate-left"></i>
                            </button>

                        </form>

                        @else

                        <button type="button"
                            class="btn btn-sm btn-outline-danger rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-action="{{ route('moderator.genres.destroy', $genre->id) }}"
                            title="Dzēst">

                            <i class="fa-solid fa-trash"></i>
                        </button>

                        @if($genre->status === 'active')

                        <form action="{{ route('moderator.genres.deactivate', $genre->id) }}"
                            method="POST">

                            @csrf

                            <button type="submit"
                                class="btn btn-sm btn-outline-warning rounded"
                                title="Deaktivēt">

                                <i class="fa-solid fa-ban"></i>
                            </button>

                        </form>

                        @else

                        <form action="{{ route('moderator.genres.activate', $genre->id) }}"
                            method="POST">

                            @csrf

                            <button type="submit"
                                class="btn btn-sm btn-outline-success rounded"
                                title="Aktivēt">

                                <i class="fa-solid fa-check"></i>
                            </button>

                        </form>

                        @endif
                        @endif

                    </td>

                </tr>

                @include('moderator.genres.edit-modal', ['genre' => $genre])

                @empty

                <tr>
                    <td colspan="5" class="text-center text-secondary py-5">

                        <i class="fa-solid fa-masks-theater fa-3x mb-3 d-block"></i>

                        Nav izveidotu žanru

                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $genres->links() }}
    </div>

</main>

    @include('moderator.genres.create-modal')

    @include('partials.footer')

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Apstiprināt dzēšanu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Vai tiešām vēlies dzēst šo ierakstu? Šī darbība ir neatgriezeniska!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Atcelt</button>
                    <form id="deleteForm" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded">Dzēst</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const action = button.getAttribute('data-action');
                const form = deleteModal.querySelector('#deleteForm');
                form.action = action;
            });
        });
    </script>
</body>

</html>