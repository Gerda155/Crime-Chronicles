<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Rangs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            Moderatora panelis - Rangi
        </h1>

        {{-- STATISTIKA --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-text">Kopā rangu</div>
                            <div class="card-title">{{ $rangs->count() }}</div>
                        </div>

                        <i class="fa-solid fa-ranking-star card-title"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-text">Aktīvie</div>
                            <div class="card-title">
                                {{ $rangs->where('status', 'active')->count() }}
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
                                {{ $rangs->where('status', 'inactive')->count() }}
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
                            <div class="card-text">Augstākais ranks</div>

                            <div class="card-title fs-6">
                                {{ $rangs->sortByDesc('min_score')->first()->name ?? 'Nav datu' }}
                            </div>
                        </div>

                        <i class="fa-solid fa-crown card-title text-warning"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- SEARCH + SORT --}}
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

                    <option value="low_score" {{ request('sort') == 'low_score' ? 'selected' : '' }}>
                        Zemākais punktu slieksnis
                    </option>

                    <option value="high_score" {{ request('sort') == 'high_score' ? 'selected' : '' }}>
                        Augstākais punktu slieksnis
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
                data-bs-target="#createRankModal">

                <i class="fa-solid fa-plus me-1"></i>
                Izveidot jaunu rangu

            </button>

        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- TABULA --}}
        <div class="table-responsive rounded shadow-sm">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead class="table-dark text-uppercase text-muted small">
                    <tr>

                        <th>#</th>

                        <th>
                            <i class="fa-solid fa-ranking-star me-1"></i>
                            Nosaukums
                        </th>

                        <th>
                            <i class="fa-solid fa-arrow-down-1-9 me-1"></i>
                            Min punkti
                        </th>

                        <th>
                            <i class="fa-solid fa-arrow-up-9-1 me-1"></i>
                            Max punkti
                        </th>

                        <th>
                            <i class="fa-solid fa-calendar me-1"></i>
                            Izveidots
                        </th>

                        <th>
                            <i class="fa-solid fa-toggle-on me-1"></i>
                            Statuss
                        </th>

                        <th>
                            <i class="fa-solid fa-gear me-1"></i>
                            Darbības
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($rangs as $rang)

                    <tr class="{{ $rang->status === 'inactive' ? 'text-secondary' : '' }}">

                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-bold">
                            {{ $rang->name }}
                        </td>

                        <td>
                            {{ $rang->min_score }}
                        </td>

                        <td>
                            {{ $rang->max_score ?? '∞' }}
                        </td>

                        <td>
                            <small>
                                {{ $rang->created_at->format('d.m.Y') }}
                            </small>
                        </td>

                        <td>

                            @if($rang->status === 'active')

                            <span class="badge bg-success">
                                <i class="fa-solid fa-check me-1"></i>
                                Aktīvs
                            </span>

                            @else

                            <span class="badge bg-danger">
                                <i class="fa-solid fa-xmark me-1"></i>
                                Neaktīvs
                            </span>

                            @endif

                        </td>

                        <td class="d-flex flex-wrap gap-1">

                            <button class="btn btn-sm btn-outline-primary rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#editRankModal{{ $rang->id }}"
                                title="Rediģēt">

                                <i class="fa-solid fa-pen"></i>

                            </button>

                            @if($rang->deleted_at)

                            <form action="{{ route('moderator.rangs.restore', $rang->id) }}"
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
                                data-action="{{ route('moderator.rangs.destroy', $rang->id) }}"
                                title="Dzēst">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                            @if($rang->status === 'active')

                            <form action="{{ route('moderator.rangs.deactivate', $rang->id) }}"
                                method="POST">

                                @csrf

                                <button type="submit"
                                    class="btn btn-sm btn-outline-warning rounded"
                                    title="Deaktivēt">

                                    <i class="fa-solid fa-toggle-off"></i>

                                </button>

                            </form>

                            @else

                            <form action="{{ route('moderator.rangs.activate', $rang->id) }}"
                                method="POST">

                                @csrf

                                <button type="submit"
                                    class="btn btn-sm btn-outline-success rounded"
                                    title="Aktivēt">

                                    <i class="fa-solid fa-toggle-on"></i>

                                </button>

                            </form>

                            @endif
                            @endif

                        </td>

                    </tr>

                    @include('moderator.rangs.edit-modal', ['rang' => $rang])

                    @empty

                    <tr>
                        <td colspan="7" class="text-center text-secondary py-5">

                            <i class="fa-solid fa-ranking-star fa-3x mb-3 d-block"></i>

                            Nav izveidotu rangu

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="mt-4">
            {{ $rangs->links() }}
        </div>

    </main>

    @include('moderator.rangs.create-modal')
    @include('partials.footer')

    {{-- DELETE MODAL --}}
    <div class="modal fade"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="deleteModalLabel"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content bg-dark text-light">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteModalLabel">
                        Apstiprināt dzēšanu
                    </h5>

                    <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">
                    Vai tiešām vēlies dzēst šo ierakstu?
                    Šī darbība ir neatgriezeniska!
                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary rounded"
                        data-bs-dismiss="modal">

                        Atcelt

                    </button>

                    <form id="deleteForm" method="POST" class="m-0">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-danger rounded">

                            Dzēst

                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const deleteModal = document.getElementById('deleteModal');

            if (deleteModal) {

                deleteModal.addEventListener('show.bs.modal', function(event) {

                    const button = event.relatedTarget;
                    const action = button.getAttribute('data-action');

                    const form = deleteModal.querySelector('#deleteForm');

                    if (form && action) {
                        form.action = action;
                    }

                });

            }

        });
    </script>

</body>

</html>