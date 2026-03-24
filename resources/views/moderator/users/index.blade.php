<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(Auth::user()->role) }} Dashboard - Lietotāji</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">
            {{ ucfirst(Auth::user()->role) }} panelis – Lietotāji
        </h1>

        <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
            <form method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control bg-secondary text-light border-0 rounded"
                    placeholder="Meklēt pēc vārda vai e-pasta">
                <button type="submit" class="btn btn-primary rounded">Meklēt</button>
            </form>

            <form method="GET" class="d-flex gap-2">
                <select name="sort" class="form-select bg-secondary text-light border-0 rounded">
                    <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Jaunākie</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Vecākie</option>
                    <option value="name" {{ request('sort')=='name' ? 'selected' : '' }}>Vārds</option>
                    <option value="email" {{ request('sort')=='email' ? 'selected' : '' }}>E-pasts</option>
                    <option value="role" {{ request('sort')=='role' ? 'selected' : '' }}>Loma</option>
                    <option value="status" {{ request('sort')=='status' ? 'selected' : '' }}>status</option>
                </select>
                <button type="submit" class="btn btn-primary rounded">Kārtot</button>
            </form>

            @if(Auth::user()->role === 'admin')
            <button type="button" class="btn btn-success rounded" data-bs-toggle="modal" data-bs-target="#addModeratorModal">
                Pievienot jaunu moderatoru
            </button>
            @endif
        </div>

        @if(Auth::user()->role === 'admin')
        <div class="modal fade" id="addModeratorModal" tabindex="-1" aria-labelledby="addModeratorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModeratorModalLabel">Moderatora pievienošanas forma</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.moderators.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Lietotājvārds</label>
                                <input type="text" name="username" class="form-control bg-secondary text-light border-0" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-pasts</label>
                                <input type="email" name="email" class="form-control bg-secondary text-light border-0" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Vārds</label>
                                <input type="text" name="name" class="form-control bg-secondary text-light border-0" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Parole</label>
                                <input type="password" name="password" class="form-control bg-secondary text-light border-0" required minlength="8">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Apstiprināt paroli</label>
                                <input type="password" name="password_confirmation" class="form-control bg-secondary text-light border-0" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success rounded">Pievienot</button>
                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Aizvērt</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

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
                    @foreach($users as $user)
                    <tr class="{{ $user->status === 'inactive' ? 'text-secondary' : '' }}">
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->status === 'inactive' ? 'Neaktīvs' : 'Aktīvs' }}</td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-sm btn-outline-info rounded" data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}">
                                Skatīt
                            </button>
                            @if(Auth::user()->role === 'admin')
                            <button type="button" class="btn btn-sm btn-outline-warning rounded" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                Rediģēt
                            </button>
                            @endif

                            @if(Auth::user()->role === 'admin' || (Auth::user()->role === 'moderator' && $user->role === 'user'))
                            <form action="{{ $user->status === 'inactive'
                                ? route(Auth::user()->role.'.users.activate', $user->id)
                                : route(Auth::user()->role.'.users.deactivate', $user->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-sm {{ $user->status === 'inactive' ? 'btn-outline-success' : 'btn-outline-danger' }} rounded">
                                    {{ $user->status === 'inactive' ? 'Aktivēt' : 'Deaktivēt' }}
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>

                    <div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-labelledby="userModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark text-light">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel{{ $user->id }}">{{ $user->name }} profils</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex gap-4 align-items-start">
                                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatar-placeholder.jpg') }}"
                                            class="rounded-circle border
                                            @if($user->role === 'admin') border-danger
                                            @elseif($user->role === 'moderator') border-warning
                                            @else border-secondary @endif"
                                            width="150" height="150" style="object-fit: cover;">

                                        <div class="flex-grow-1 text-white">
                                            <h4 class="@if($user->role === 'admin') text-danger fw-bold
                                                @elseif($user->role === 'moderator') text-warning fw-bold
                                                @endif">{{ $user->name }}</h4>
                                            <p>{{ $user->bio ?? 'Lietotājs vēl nav pievienojis bio.' }}</p>

                                            <h5 class="mt-2">Sasniegumi</h5>
                                            @if($user->achievements && $user->achievements->count())
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($user->achievements as $achievement)
                                                <span class="badge bg-secondary">{{ $achievement->title }}</span>
                                                @endforeach
                                            </div>
                                            @else
                                            <p class="text-white">Nav neviena sasnieguma</p>
                                            @endif

                                            <p class="text-secondary mt-2 mb-0" style="font-size: 0.9rem;">Pabeigtas lietas: {{ $user->completed_tasks_count ?? 0 }}</p>
                                            <p class="text-secondary mb-0" style="font-size: 0.9rem;">Detektīvs kopš: {{ $user->created_at->format('d.m.Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Aizvērt</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'admin')
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                                @endif

                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Moderatora rediģēšanas forma</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Loma</label>
                                            <select name="role" class="form-select bg-secondary text-light border-0" required>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                                <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">status</label>
                                            <select name="status" class="form-select bg-secondary text-light border-0" required>
                                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Aktīvs</option>
                                                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Neaktīvs</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success rounded">Saglabāt</button>
                                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Aizvērt</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    @endforeach
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