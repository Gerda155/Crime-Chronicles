<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Achievements</title>
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
            Moderatora panelis - Sasniegumi
        </h1>

        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-text">Kopā sasniegumu</div>
                            <div class="card-title">{{ $achievements->count() }}</div>
                        </div>

                        <i class="fa-solid fa-trophy card-title text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-text">Aktīvi</div>
                            <div class="card-title">
                                {{ $achievements->where('status', 'active')->count() }}
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
                            <div class="card-text">Neaktīvi</div>
                            <div class="card-title">
                                {{ $achievements->where('status', 'inactive')->count() }}
                            </div>
                        </div>

                        <i class="fa-solid fa-circle-xmark card-title text-danger"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-text">Grūtākais</div>

                            <div class="card-title fs-6">
                                {{ $achievements->sortByDesc('required_cases')->first()->title ?? 'Nav datu' }}
                            </div>
                        </div>

                        <i class="fa-solid fa-fire card-title text-danger"></i>
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
                    placeholder="Meklēt pēc nosaukuma vai apraksta">

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

                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                        Nosaukums A-Z
                    </option>

                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                        Nosaukums Z-A
                    </option>

                    <option value="easy" {{ request('sort') == 'easy' ? 'selected' : '' }}>
                        Vieglākie
                    </option>

                    <option value="hard" {{ request('sort') == 'hard' ? 'selected' : '' }}>
                        Grūtākie
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
                data-bs-target="#createAchievementModal">

                <i class="fa-solid fa-plus me-1"></i>
                Izveidot
            </button>
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
                        <th><i class="fa-solid fa-trophy me-1"></i>Nosaukums</th>
                        <th><i class="fa-solid fa-align-left me-1"></i>Apraksts</th>
                        <th><i class="fa-solid fa-image me-1"></i>Ikona</th>
                        <th><i class="fa-solid fa-star me-1"></i> Nepieciešamās lietas</th>
                        <th><i class="fa-solid fa-toggle-on me-1"></i>Statuss</th>
                        <th><i class="fa-solid fa-calendar me-1"></i>Izveidots</th>
                        <th><i class="fa-solid fa-gear me-1"></i>Darbības</th>
                    </tr>

                </thead>

                <tbody>
                    @forelse($achievements as $achievement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-bold">
                            {{ $achievement->title }}
                        </td>

                        <td>
                            {{ Str::limit($achievement->description, 60) }}
                        </td>

                        <td>
                            <img src="{{ $achievement->icon ? asset('storage/'.$achievement->icon) : asset('storage/achievements/default.png') }}"
                                width="70"
                                height="70"
                                class="rounded"
                                style="object-fit: cover;">
                        </td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $achievement->required_cases }}
                            </span>
                        </td>

                        <td>

                            @if($achievement->status === 'active')

                            <span class="badge bg-success">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                Aktīvs
                            </span>

                            @else

                            <span class="badge bg-danger">
                                <i class="fa-solid fa-circle-xmark me-1"></i>
                                Neaktīvs
                            </span>

                            @endif

                        </td>

                        <td>
                            <small>
                                22.11.26
                            </small>
                        </td>

                        <td class="align-middle ">

                            <button class="btn btn-sm btn-outline-primary rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#editAchievementModal{{ $achievement->id }}"
                                title="Rediģēt">

                                <i class="fa-solid fa-pen"></i>
                            </button>

                            @if($achievement->deleted_at)

                            <form action="{{ route('moderator.achievements.restore', $achievement->id) }}"
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
                                data-action="{{ route('moderator.achievements.destroy', $achievement->id) }}"
                                title="Dzēst">

                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @if($achievement->status === 'active')

                            <form action="{{ route('moderator.achievements.deactivate', $achievement->id) }}"
                                method="POST">

                                @csrf

                                <button type="submit"
                                    class="btn btn-sm btn-outline-warning rounded"
                                    title="Deaktivēt">

                                    <i class="fa-solid fa-ban"></i>
                                </button>

                            </form>

                            @else

                            <form action="{{ route('moderator.achievements.activate', $achievement->id) }}"
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

                    @include('moderator.achievements.edit-modal', ['achievement' => $achievement])

                    @empty

                    <tr>
                        <td colspan="8" class="text-center text-secondary py-5">

                            <i class="fa-solid fa-trophy fa-3x mb-3 d-block"></i>

                            Nav izveidotu sasniegumu
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="mt-4">
            {{ $achievements->links() }}
        </div>

    </main>

    @include('moderator.achievements.create-modal')
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