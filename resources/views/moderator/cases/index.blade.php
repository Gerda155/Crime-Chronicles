<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard - Lietas</title>
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
            Moderatora panelis - Lietas
        </h1>

        <div class="row g-3 mb-4">

            <div class="col-md-2">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="card-text">Kopā lietu</div>
                            <div class="card-title">{{ $cases->count() }}</div>
                        </div>

                        <i class="fa-solid fa-folder card-title"></i>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="card-text">Aktīvas</div>
                            <div class="card-title">
                                {{ $cases->where('status', 'active')->count() }}
                            </div>
                        </div>

                        <i class="fa-solid fa-circle-check card-title text-success"></i>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="card-text">Neaktīvas</div>
                            <div class="card-title">
                                {{ $cases->where('status', 'inactive')->count() }}
                            </div>
                        </div>

                        <i class="fa-solid fa-circle-xmark card-title text-danger"></i>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="card-text">Tutorial</div>
                            <div class="card-title">
                                {{ $cases->where('is_tutorial', true)->count() }}
                            </div>
                        </div>

                        <i class="fa-solid fa-graduation-cap card-title"></i>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="card-text">Vidējais reitings</div>
                            <div class="card-title">
                                {{ number_format($cases->avg('rating') ?? 0, 1) }}
                            </div>
                        </div>

                        <i class="fa-solid fa-star card-title text-warning"></i>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="card-text">TOP lieta</div>

                            <div class="card-title fs-6">
                                {{ $cases->sortByDesc('rating')->first()->title ?? 'Nav datu' }}
                            </div>
                        </div>

                        <i class="fa-solid fa-crown card-title text-warning"></i>

                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex flex-wrap gap-2 mb-3">

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
                        Jaunākās lietas
                    </option>

                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                        Vecākās lietas
                    </option>

                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>
                        Augstākais vērtējums
                    </option>

                    <option value="alphabet" {{ request('sort') == 'alphabet' ? 'selected' : '' }}>
                        Nosaukums A-Z
                    </option>

                    <option value="alphabet_desc" {{ request('sort') == 'alphabet_desc' ? 'selected' : '' }}>
                        Nosaukums Z-A
                    </option>

                    <option value="tutorials" {{ request('sort') == 'tutorials' ? 'selected' : '' }}>
                        Tutorial lietas
                    </option>

                    <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>
                        Aktīvas
                    </option>

                    <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>
                        Neaktīvas
                    </option>

                </select>

                <button type="submit" class="btn btn-primary rounded">
                    Kārtot
                </button>

            </form>

            <a href="{{ route('moderator.cases.create') }}"
                class="btn btn-success rounded">

                <i class="fa-solid fa-plus me-1"></i>
                Izveidot lietu
            </a>

        </div>

        @if(session('success'))

        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>

        @endif

        <div class="table-responsive rounded shadow-sm">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead class="table-dark text-uppercase text-muted small">

                    <tr>

                        <th>#</th>

                        <th>
                            <i class="fa-solid fa-folder me-1"></i>
                            Nosaukums
                        </th>

                        <th>
                            <i class="fa-solid fa-align-left me-1"></i>
                            Apraksts
                        </th>

                        <th>
                            <i class="fa-solid fa-masks-theater me-1"></i>
                            Žanrs
                        </th>

                        <th>
                            <i class="fa-solid fa-star me-1"></i>
                            Reitings
                        </th>

                        <th>
                            <i class="fa-solid fa-graduation-cap me-1"></i>
                            Tutorial
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

                    @forelse($cases as $case)

                    <tr class="{{ $case->status === 'inactive' ? 'text-secondary' : '' }}">

                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-bold">
                            {{ $case->title }}
                        </td>

                        <td>
                            {{ Str::limit($case->description, 60) }}
                        </td>

                        <td>
                            {{ $case->genre->name ?? '-' }}
                        </td>

                        <td>

                            <div class="rating-stars">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <=round($case->rating ?? 0))
                                    <i class="fa-solid fa-star"></i>
                                    @else
                                    <i class="fa-regular fa-star"></i>
                                    @endif

                                    @endfor

                            </div>

                            <small class="text-secondary">
                                {{ number_format($case->rating ?? 0, 1) }}
                            </small>

                        </td>

                        <td>

                            @if($case->is_tutorial)

                            <span class="badge bg-info">
                                <i class="fa-solid fa-check me-1"></i>
                                Tutorial
                            </span>

                            @else

                            <span class="text-secondary">
                                —
                            </span>

                            @endif

                        </td>

                        <td>

                            @if($case->status === 'active')

                            <span class="badge bg-success">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                Aktīva
                            </span>

                            @else

                            <span class="badge bg-danger">
                                <i class="fa-solid fa-circle-xmark me-1"></i>
                                Neaktīva
                            </span>

                            @endif

                        </td>

                        <td>
                            <small>
                                {{ $case->created_at->format('d.m.Y') }}
                            </small>
                        </td>

                        <td>

                            <button type="button"
                                class="btn btn-sm {{ $case->is_tutorial ? 'btn-success' : 'btn-outline-info' }} rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#tutorialModal"
                                data-action="{{ route('moderator.cases.setTutorial', $case->id) }}"
                                title="Tutorial">

                                <i class="fa-solid fa-graduation-cap"></i>
                            </button>

                            <a href="{{ route('moderator.cases.edit', $case->id) }}"
                                class="btn btn-sm btn-outline-primary rounded"
                                title="Rediģēt">

                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ $case->status === 'inactive'
                            ? route('moderator.cases.activate', $case->id)
                            : route('moderator.cases.deactivate', $case->id) }}"
                                method="POST">

                                @csrf
                                @method('PUT')

                                <button type="submit"
                                    class="btn btn-sm {{ $case->status === 'inactive' ? 'btn-outline-success' : 'btn-outline-warning' }} rounded"
                                    title="{{ $case->status === 'inactive' ? 'Aktivēt' : 'Deaktivēt' }}">

                                    @if($case->status === 'inactive')
                                    <i class="fa-solid fa-check"></i>
                                    @else
                                    <i class="fa-solid fa-ban"></i>
                                    @endif

                                </button>

                            </form>

                            <button type="button"
                                class="btn btn-sm btn-outline-danger rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-action="{{ route('moderator.cases.destroy', $case->id) }}"
                                title="Dzēst">

                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @if($case->trashed())

                            <form action="{{ route('moderator.cases.restore', $case->id) }}"
                                method="POST">

                                @csrf

                                <button class="btn btn-sm btn-outline-success rounded"
                                    title="Atjaunot">

                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>

                            </form>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9" class="text-center text-secondary py-5">

                            <i class="fa-solid fa-folder-open fa-3x mb-3 d-block"></i>

                            Nav izveidotu lietu

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $cases->links() }}
        </div>

    </main>
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

    <div class="modal fade" id="tutorialModal" tabindex="-1" aria-labelledby="tutorialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="tutorialModalLabel">Tutorial apstiprināšana</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Sistēmā vienlaicīgi var būt tikai viens tutorial.
                    Vai tiešām vēlies šo lietu iestatīt kā tutorial?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">
                        Atcelt
                    </button>

                    <form id="tutorialForm" method="POST">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn btn-info rounded">
                            Apstiprināt
                        </button>
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

        const tutorialModal = document.getElementById('tutorialModal');

        tutorialModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');

            const form = tutorialModal.querySelector('#tutorialForm');
            form.action = action;
        });
    </script>

</body>

</html>