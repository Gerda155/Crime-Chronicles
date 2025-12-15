<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4">Mani līmeņi</h1>

        <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
            <form method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Meklēt pēc nosaukuma">
                <button type="submit" class="btn btn-primary">Meklēt</button>
            </form>

            <form method="GET" class="d-flex gap-2">
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Jaunākie</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Vecākie</option>
                    <option value="rating" {{ request('sort')=='rating' ? 'selected' : '' }}>Vērtējums</option>
                    <option value="title" {{ request('sort')=='title' ? 'selected' : '' }}>Nosaukums</option>
                    <option value="genre" {{ request('sort')=='genre' ? 'selected' : '' }}>Žanrs</option>
                </select>
                <button type="submit" class="btn btn-primary">Kārtot</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nosaukums</th>
                        <th>Apraksts</th>
                        <th>Žanrs</th>
                        <th>Vērtējums</th>
                        <th>Darbības</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cases as $case)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $case->title }}</td>
                        <td>{{ Str::limit($case->description, 50) }}</td>
                        <td>{{ $case->genre->name ?? '-' }}</td>
                        <td>{{ $case->rating ?? '0' }}</td>
                        <td>
                            <a href="{{ route('cases.edit', $case->id) }}" class="btn btn-sm btn-primary mb-1">Rediģēt</a>

                            <!-- Кнопка для модалки -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $case->id }}">
                                Dzēst
                            </button>

                            <!-- Модальное окно -->
                            <div class="modal fade" id="deleteModal{{ $case->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $case->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $case->id }}">Apstiprināt dzēšanu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Aizvērt"></button>
                                        </div>
                                        <div class="modal-body">
                                            Vai tiešām vēlies dzēst līmeni "{{ $case->title }}"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atcelt</button>
                                            <form action="{{ route('cases.destroy', $case->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Dzēst</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nav izveidotu līmeņu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    @include('partials.footer')

</body>

</html>