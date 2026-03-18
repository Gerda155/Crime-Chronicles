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
                    <option value="statuss" {{ request('sort')=='statuss' ? 'selected' : '' }}>Statuss</option>
                </select>
                <button type="submit" class="btn btn-primary rounded">Kārtot</button>
            </form>

            <a href="{{ route('moderator.achievements.create') }}" class="btn btn-success rounded">Izveidot jaunu sasniegumu</a>
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
                            <img
                                src="{{ $achievement->icon
                                ? asset('storage/'.$achievement->icon)
                                : asset('storage/achievements/default.png') }}"
                                class="mx-auto mb-3"
                                width="80"
                                height="80"
                                style="object-fit: contain;">

                        </td>

                        <td>
                            <a href="{{ route('moderator.achievements.edit', $achievement->id) }}"
                                class="btn btn-sm btn-outline-primary rounded">
                                Rediģēt
                            </a>

                            <form action="{{ route('moderator.achievements.destroy', $achievement->id) }}" method="POST" class="m-0 p-0 d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded">Dzēst</button>
                            </form>
                        </td>

                    </tr>
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

    @include('partials.footer')
</body>

</html>