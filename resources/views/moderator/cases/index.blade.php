<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard - Lietas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">Moderatora panelis - Lietas</h1>

        <div class="d-flex flex-wrap gap-2 mb-3">
            <form method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-secondary text-light border-0 rounded" placeholder="Meklēt pēc nosaukuma">
                <button type="submit" class="btn btn-primary rounded">Meklēt</button>
            </form>
            <form method="GET" class="d-flex gap-2">
                <select name="sort" class="form-select bg-secondary text-light border-0 rounded">
                    <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Jaunākie</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Vecākie</option>
                    <option value="rating" {{ request('sort')=='rating' ? 'selected' : '' }}>Vērtējums</option>
                    <option value="title" {{ request('sort')=='title' ? 'selected' : '' }}>Nosaukums</option>
                    <option value="genre" {{ request('sort')=='genre' ? 'selected' : '' }}>Žanrs</option>
                    <option value="status" {{ request('sort')=='status' ? 'selected' : '' }}>status</option>
                </select>
                <button type="submit" class="btn btn-primary rounded">Kārtot</button>
            </form>

            <a href="{{ route('moderator.cases.create') }}" class="btn btn-success rounded">Izveidot jaunu lietu</a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive rounded shadow-sm">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="table-dark text-uppercase text-muted small">
                    <tr>
                        <th>#</th>
                        <th>Nosaukums</th>
                        <th>Apraksts</th>
                        <th>Žanrs</th>
                        <th>Statuss</th>
                        <th>Darbības</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cases as $case)
                    <tr class="{{ $case->status === 'inactive' ? 'text-secondary' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $case->title }}</td>
                        <td>{{ Str::limit($case->description, 50) }}</td>
                        <td>{{ $case->genre->name ?? '-' }}</td>
                        <td>{{ $case->status === 'inactive' ? 'Neaktīvs' : 'Aktīvs' }}</td>
                        <td class="d-flex flex-wrap gap-1">
                            <a href="{{ route('moderator.cases.edit', $case->id) }}" class="btn btn-sm btn-outline-primary rounded">Rediģēt</a>

                            <form action="{{ $case->status === 'inactive' 
                            ? route('moderator.cases.activate', $case->id) 
                            : route('moderator.cases.deactivate', $case->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm {{ $case->status === 'inactive' ? 'btn-outline-success' : 'btn-outline-warning' }} rounded">
                                    {{ $case->status === 'inactive' ? 'Aktivēt' : 'Deaktivēt' }}
                                </button>
                            </form>

                            <button type="button"
                                class="btn btn-sm btn-outline-danger rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-action="{{ route('moderator.cases.destroy', $case->id) }}">
                                Dzēst
                            </button>

                            @if($case->trashed())
                            <form action="{{ route('moderator.cases.restore', $case->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-outline-success rounded">Atjaunot</button>
                            </form>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary">Nav izveidotu līmeņu</td>
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