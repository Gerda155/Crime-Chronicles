<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard - Sasniegumi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">Moderatora panelis - Sasniegumi</h1>

        <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
            <form method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control bg-secondary text-light border-0 rounded"
                    placeholder="Meklēt pēc nosaukuma vai apraksta">
                <button type="submit" class="btn btn-primary rounded">Meklēt</button>
            </form>

            <form method="GET" class="d-flex gap-2">
                <select name="sort" class="form-select bg-secondary text-light border-0 rounded">
                    <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Jaunākie</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Vecākie</option>
                    <option value="title" {{ request('sort')=='title' ? 'selected' : '' }}>Nosaukums</option>
                    <option value="points" {{ request('sort')=='points' ? 'selected' : '' }}>Punkti</option>
                </select>
                <button type="submit" class="btn btn-primary rounded">Kārtot</button>
            </form>

            <button class="btn btn-success rounded" data-bs-toggle="modal" data-bs-target="#createAchievementModal">
                Izveidot jaunu sasniegumu
            </button>
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
                        <th>Ikona</th>
                        <th>Darbības</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($achievements as $achievement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $achievement->title }}</td>
                        <td>{{ Str::limit($achievement->description, 50) }}</td>
                        <td>
                            <img src="{{ $achievement->icon ? asset('storage/'.$achievement->icon) : asset('storage/achievements/default.png') }}"
                                width="80" height="80" style="object-fit: contain;">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary rounded" data-bs-toggle="modal"
                                data-bs-target="#editAchievementModal{{ $achievement->id }}">
                                Rediģēt
                            </button>

                            @if($achievement->deleted_at)
                            <form action="{{ route('moderator.achievements.restore', $achievement->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success rounded">Atjaunot</button>
                            </form>
                            @else

                            <button type="button"
                                class="btn btn-sm btn-outline-danger rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-action="{{ route('moderator.achievements.destroy', $achievement->id) }}">
                                Dzēst
                            </button>

                            @if($achievement->status === 'active')
                            <form action="{{ route('moderator.achievements.deactivate', $achievement->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning rounded">Deaktivēt</button>
                            </form>
                            @else
                            <form action="{{ route('moderator.achievements.activate', $achievement->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success rounded">Aktivēt</button>
                            </form>
                            @endif
                            @endif
                        </td>
                    </tr>

                    @include('moderator.achievements.edit-modal', ['achievement' => $achievement])
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary">Nav izveidotu sasniegumu</td>
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