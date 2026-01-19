<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard - Lietotāji</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">
            Moderatora panelis – Lietotāji
        </h1>

        <div class="d-flex flex-wrap gap-2 mb-3">
            <form method="GET" class="d-flex gap-2 flex-grow-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control bg-secondary text-light border-0 rounded"
                    placeholder="Meklēt pēc vārda vai e-pasta">
                <button class="btn btn-primary rounded">Meklēt</button>
            </form>

            <form method="GET" class="d-flex gap-2">
                <select name="sort" class="form-select bg-secondary text-light border-0 rounded">
                    <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Jaunākie</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Vecākie</option>
                    <option value="name" {{ request('sort')=='name' ? 'selected' : '' }}>Vārds</option>
                    <option value="email" {{ request('sort')=='email' ? 'selected' : '' }}>E-pasts</option>
                    <option value="role" {{ request('sort')=='role' ? 'selected' : '' }}>Loma</option>
                    <option value="status" {{ request('sort')=='status' ? 'selected' : '' }}>Statuss</option>
                </select>
                <button class="btn btn-primary rounded">Kārtot</button>
            </form>
        </div>

        <div class="table-responsive rounded shadow-sm">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="text-uppercase text-muted small">
                    <tr>
                        <th>#</th>
                        <th>Vārds</th>
                        <th>E-pasts</th>
                        <th>Loma</th>
                        <th>Statuss</th>
                        <th>Darbības</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="{{ $user->statuss === 'neaktivs' ? 'text-secondary' : '' }}">
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->statuss === 'neaktivs' ? 'Neaktīvs' : 'Aktīvs' }}</td>
                        <td>
                            <form
                                action="{{ $user->statuss === 'neaktivs'
        ? route('moderator.users.activate', $user->id)
        : route('moderator.users.deactivate', $user->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT') 
                                <button class="btn btn-sm {{ $user->statuss === 'neaktivs'
        ? 'btn-outline-success'
        : 'btn-outline-danger' }} rounded">
                                    {{ $user->statuss === 'neaktivs' ? 'Aktivēt' : 'Deaktivēt' }}
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary">Nav lietotāju</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>

    </main>

    @include('partials.footer')
</body>

</html>