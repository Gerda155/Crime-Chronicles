{{-- resources/views/moderator/cases.blade.php --}}
<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard — Dela</title>

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
                    <option value="statuss" {{ request('sort')=='statuss' ? 'selected' : '' }}>Statuss</option>
                </select>
                <button type="submit" class="btn btn-primary rounded">Kārtot</button>
            </form>
        </div>

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
                    <tr class="{{ $case->statuss === 'neaktivs' ? 'text-secondary' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $case->title }}</td>
                        <td>{{ Str::limit($case->description, 50) }}</td>
                        <td>{{ $case->genre->name ?? '-' }}</td>
                        <td>{{ $case->statuss === 'neaktivs' ? 'Neaktīvs' : 'Aktīvs' }}</td>
                        <td class="d-flex flex-wrap gap-1">

                            {{-- Редактировать --}}
                            <a href="{{ route('moderator.cases.edit', $case->id) }}" class="btn btn-sm btn-outline-primary rounded">Rediģēt</a>

                            <form action="{{ $case->statuss === 'neaktivs' 
    ? route('moderator.cases.activate', $case->id) 
    : route('moderator.cases.deactivate', $case->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm {{ $case->statuss === 'neaktivs' ? 'btn-outline-success' : 'btn-outline-danger' }} rounded">
                                    {{ $case->statuss === 'neaktivs' ? 'Aktivēt' : 'Deaktivēt' }}
                                </button>
                            </form>


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
        @if ($cases->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center my-4">
                {{-- Previous Page Link --}}
                @if ($cases->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                <li class="page-item">
                    <a class="page-link text-light bg-dark border-danger" href="{{ $cases->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
                @endif

                {{-- Page Links --}}
                @foreach ($cases->links()->elements[0] ?? [] as $page => $url)
                <li class="page-item">
                    <a class="page-link {{ $page == $cases->currentPage() ? 'bg-danger text-dark' : 'text-light bg-dark border-danger' }}" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($cases->hasMorePages())
                <li class="page-item">
                    <a class="page-link text-light bg-dark border-danger" href="{{ $cases->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
                @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
        @endif
    </main>

    @include('partials.footer')
</body>

</html>