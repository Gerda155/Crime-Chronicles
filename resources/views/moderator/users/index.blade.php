<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(Auth::user()->role) }} Dashboard - Lietotāji</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            {{ ucfirst(Auth::user()->role) }} panelis - Lietotāji
        </h1>

        <div class="row g-3 mb-4">

            <div class="{{ Auth::user()->role === 'admin' ? 'col-lg-2 col-md-4 col-6' : 'col-lg-3 col-md-6 col-12' }}">
                <div class="card border-0 rounded-4 p-3 h-100 shadow-sm bg-dark-subtle">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-secondary small mb-1">
                                Kopā lietotāju
                            </div>

                            <div class="fs-3 fw-bold text-light">
                                {{ $users->count() }}
                            </div>

                        </div>

                        <div class="bg-primary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 55px; height: 55px;">

                            <i class="fa-solid fa-users text-primary fs-4"></i>

                        </div>

                    </div>

                </div>
            </div>

            <div class="{{ Auth::user()->role === 'admin' ? 'col-lg-2 col-md-4 col-6' : 'col-lg-3 col-md-6 col-12' }}">
                <div class="card border-0 rounded-4 p-3 h-100 shadow-sm bg-dark-subtle">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-secondary small mb-1">
                                Aktīvi
                            </div>

                            <div class="fs-3 fw-bold text-success">
                                {{ $users->where('status', 'active')->count() }}
                            </div>

                        </div>

                        <div class="bg-success bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 55px; height: 55px;">

                            <i class="fa-solid fa-user-check text-success fs-4"></i>

                        </div>

                    </div>

                </div>
            </div>

            <div class="{{ Auth::user()->role === 'admin' ? 'col-lg-2 col-md-4 col-6' : 'col-lg-3 col-md-6 col-12' }}">
                <div class="card border-0 rounded-4 p-3 h-100 shadow-sm bg-dark-subtle">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-secondary small mb-1">
                                Bloķēti
                            </div>

                            <div class="fs-3 fw-bold text-danger">
                                {{ $users->where('status', 'inactive')->count() }}
                            </div>

                        </div>

                        <div class="bg-danger bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 55px; height: 55px;">

                            <i class="fa-solid fa-user-xmark text-danger fs-4"></i>

                        </div>

                    </div>

                </div>
            </div>

            @if(Auth::user()->role === 'admin')

            <div class="col-lg-2 col-md-4 col-6">
                <div class="card border-0 rounded-4 p-3 h-100 shadow-sm bg-dark-subtle">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-secondary small mb-1">
                                Moderatori
                            </div>

                            <div class="fs-3 fw-bold text-warning">
                                {{ $users->where('role', 'moderator')->count() }}
                            </div>

                        </div>

                        <div class="bg-warning bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 55px; height: 55px;">

                            <i class="fa-solid fa-user-shield text-warning fs-4"></i>

                        </div>

                    </div>

                </div>
            </div>

            @endif

            <div class="{{ Auth::user()->role === 'admin' ? 'col-lg-4 col-md-8 col-12' : 'col-lg-3 col-md-6 col-12' }}">
                <div class="card border-0 rounded-4 p-3 h-100 shadow-sm bg-dark-subtle">

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="overflow-hidden">

                            <div class="text-secondary small mb-1">
                                TOP detektīvs
                            </div>

                            <div class="fw-bold text-info text-truncate"
                                style="max-width: 180px;">

                                {{ $users->sortByDesc('completed_cases_count')->first()->name ?? 'Nav datu' }}

                            </div>

                            <small class="text-secondary">

                                {{ $users->sortByDesc('completed_cases_count')->first()->completed_cases_count ?? 0 }}
                                atrisinātas lietas

                            </small>

                        </div>

                        <div class="bg-info bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 55px; height: 55px;">

                            <i class="fa-solid fa-trophy text-info fs-4"></i>

                        </div>

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
                    placeholder="Meklēt pēc vārda vai e-pasta">

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
                        Vārds A-Z
                    </option>

                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                        Vārds Z-A
                    </option>

                    <option value="username" {{ request('sort') == 'username' ? 'selected' : '' }}>
                        Segvārds
                    </option>

                    <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>
                        E-pasts
                    </option>

                    <option value="role" {{ request('sort') == 'role' ? 'selected' : '' }}>
                        Loma
                    </option>

                    <option value="status_active" {{ request('sort') == 'status_active' ? 'selected' : '' }}>
                        Aktīvie
                    </option>

                    <option value="status_inactive" {{ request('sort') == 'status_inactive' ? 'selected' : '' }}>
                        Bloķētie
                    </option>

                    <option value="most_cases" {{ request('sort') == 'most_cases' ? 'selected' : '' }}>
                        Visvairāk atrisināto lietu
                    </option>

                    <option value="most_achievements" {{ request('sort') == 'most_achievements' ? 'selected' : '' }}>
                        Visvairāk sasniegumu
                    </option>

                </select>

                <button type="submit" class="btn btn-primary rounded">
                    Kārtot
                </button>

            </form>

            @if(Auth::user()->role === 'admin')

            <button type="button"
                class="btn btn-success rounded"
                data-bs-toggle="modal"
                data-bs-target="#addModeratorModal">

                <i class="fa-solid fa-plus me-1"></i>
                Pievienot moderatoru
            </button>

            @endif

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
                            <i class="fa-solid fa-user me-1"></i>
                            Lietotājs
                        </th>

                        <th>
                            <i class="fa-solid fa-envelope me-1"></i>
                            E-pasts
                        </th>

                        <th>
                            <i class="fa-solid fa-user-tag me-1"></i>
                            Loma
                        </th>

                        <th>
                            <i class="fa-solid fa-toggle-on me-1"></i>
                            Statuss
                        </th>

                        <th>
                            <i class="fa-solid fa-calendar me-1"></i>
                            Reģistrācija
                        </th>

                        <th>
                            <i class="fa-solid fa-gear me-1"></i>
                            Darbības
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                    <tr class="{{ $user->status === 'inactive' ? 'text-secondary' : '' }}">

                        <td>
                            {{ $users->firstItem() + $loop->index }}
                        </td>

                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatar-placeholder.jpg') }}"
                                    width="45"
                                    height="45"
                                    class="rounded-circle border"
                                    style="object-fit: cover;">

                                <div>

                                    <div class="fw-bold">
                                        {{ $user->name }}
                                    </div>

                                    <small class="text-secondary">
                                        {{ '@'.$user->username }}
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>

                            @if($user->role === 'admin')

                            <span class="badge bg-danger">
                                <i class="fa-solid fa-crown me-1"></i>
                                Admin
                            </span>

                            @elseif($user->role === 'moderator')

                            <span class="badge bg-warning text-dark">
                                <i class="fa-solid fa-user-shield me-1"></i>
                                Moderator
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                <i class="fa-solid fa-user me-1"></i>
                                User
                            </span>

                            @endif

                        </td>

                        <td>

                            @if($user->status === 'active')

                            <span class="badge bg-success">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                Aktīvs
                            </span>

                            @else

                            <span class="badge bg-danger">
                                <i class="fa-solid fa-circle-xmark me-1"></i>
                                Bloķēts
                            </span>

                            @endif

                        </td>

                        <td>
                            <small>
                                {{ $user->created_at->format('d.m.Y') }}
                            </small>
                        </td>

                        <td>

                            <div class="d-flex flex-wrap gap-1">

                                <button type="button"
                                    class="btn btn-sm btn-outline-info rounded"
                                    data-bs-toggle="modal"
                                    data-bs-target="#userModal{{ $user->id }}"
                                    title="Skatīt">

                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                @if(Auth::user()->role === 'admin')

                                <button type="button"
                                    class="btn btn-sm btn-outline-primary rounded"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user->id }}"
                                    title="Rediģēt">

                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                @endif

                                @if(Auth::user()->role === 'admin' || (Auth::user()->role === 'moderator' && $user->role === 'user'))

                                <form action="{{ $user->status === 'inactive'
                                ? route(Auth::user()->role.'.users.activate', $user->id)
                                : route(Auth::user()->role.'.users.deactivate', $user->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                        class="btn btn-sm {{ $user->status === 'inactive' ? 'btn-outline-success' : 'btn-outline-warning' }} rounded"
                                        title="{{ $user->status === 'inactive' ? 'Aktivēt' : 'Bloķēt' }}">

                                        @if($user->status === 'inactive')
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
                                    data-action="{{ route('moderator.users.destroy', $user->id) }}"
                                    title="Dzēst">

                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                @if($user->trashed())

                                <form action="{{ route(Auth::user()->role.'.users.restore', $user->id) }}"
                                    method="POST">

                                    @csrf

                                    <button class="btn btn-sm btn-outline-success rounded"
                                        title="Atjaunot">

                                        <i class="fa-solid fa-rotate-left"></i>
                                    </button>

                                </form>

                                @endif

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center text-secondary py-5">

                            <i class="fa-solid fa-users fa-3x mb-3 d-block"></i>

                            Nav atrastu lietotāju

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </main>

    @include('partials.footer')

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">

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
                    Vai tiešām vēlies dzēst šo lietotāju? Šī darbība ir neatgriezeniska!
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

                        <button type="submit" class="btn btn-danger rounded">
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