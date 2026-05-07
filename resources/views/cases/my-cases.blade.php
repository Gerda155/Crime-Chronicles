<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold text-pink">
            <i class="fa-solid fa-folder-open me-2"></i>
            Manas lietas
        </h1>

        {{-- STATISTIKA --}}
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
                            <div class="card-text">Vidējais vērtējums</div>
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
                            <div class="card-text">Aktīvas lietas</div>
                            <div class="card-title">
                                {{ $cases->where('is_active', true)->count() }}
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
                            <div class="card-text">Arhivētas</div>
                            <div class="card-title">
                                {{ $cases->where('is_active', false)->count() }}
                            </div>
                        </div>

                        <i class="fa-solid fa-box-archive card-title text-danger"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card rounded p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-text">Gaida apstiprinājumu</div>
                            <div class="card-title">
                                {{ $cases->where('is_active', false)->count() }}
                            </div>
                        </div>

                        <i class="fa-solid fa-clock card-title"></i>
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

        {{-- FILTRI --}}
        <div class="d-flex flex-wrap gap-2 mb-3">
            <form method="GET" class="d-flex gap-2 flex-grow-1">
                <span class="input-group-text bg-secondary border-0 text-light">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
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

            <a href="{{ route('user.cases.create') }}" class="btn btn-success rounded">Izveidot jaunu lietu</a>
        </div>

        @if(session('status'))
        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info me-2"></i>
            {{ session('status') }}
        </div>
        @endif

        {{-- TABULA --}}
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
                            Vērtējums
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

                    @forelse($cases as $case)

                    <tr class="align-middle">

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
                            <small>
                                {{ $case->created_at->format('d.m.Y') }}
                            </small>
                        </td>

                        <td>

                            @if($case->status !== 'pending')

                            <form method="POST" action="{{ route('cases.toggle-status', $case->id) }}">
                                @csrf
                                @method('PATCH')

                                <button class="status-switch {{ $case->status === 'active' ? 'active' : '' }}"type="submit">
                                    <span class="switch-circle"></span>
                                </button>

                            </form>

                            @else

                            <span class="status-pending">
                                <i class="fa-solid fa-clock me-1"></i>
                                Gaida
                            </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('cases.edit', $case->id) }}"
                                class="btn btn-sm btn-outline-primary rounded"
                                title="Rediģēt">

                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <button type="button"
                                class="btn btn-sm btn-outline-danger rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $case->id }}"
                                title="Dzēst">

                                <i class="fa-solid fa-trash"></i>
                            </button>

                            {{-- DELETE MODAL --}}
                            <div class="modal fade"
                                id="deleteModal{{ $case->id }}"
                                tabindex="-1"
                                aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content bg-secondary text-light rounded">

                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                Apstiprināt dzēšanu
                                            </h5>

                                            <button type="button"
                                                class="btn-close btn-close-white"
                                                data-bs-dismiss="modal">
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            Vai tiešām vēlies dzēst lietu
                                            <strong>"{{ $case->title }}"</strong>?
                                        </div>

                                        <div class="modal-footer">

                                            <button type="button"
                                                class="btn btn-outline-light rounded"
                                                data-bs-dismiss="modal">
                                                Atcelt
                                            </button>

                                            <form action="{{ route('cases.destroy', $case->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn btn-outline-danger rounded">

                                                    <i class="fa-solid fa-trash me-1"></i>
                                                    Dzēst
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center text-secondary py-5">

                            <i class="fa-solid fa-folder-open fa-3x mb-3 d-block"></i>

                            Nav izveidotu lietu

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

    @include('partials.footer')

</body>

</html>