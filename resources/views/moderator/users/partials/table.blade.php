<div class="table-responsive rounded shadow-sm">

    <table class="table table-dark table-hover align-middle mb-0">

        <thead class="table-dark text-uppercase text-muted small">

            <tr>
                <th>#</th>
                <th>Lietotājs</th>
                <th>E-pasts</th>
                <th>Loma</th>
                <th>Statuss</th>
                <th>Darbības</th>
            </tr>

        </thead>

        <tbody>

            @forelse($users as $user)

                @php
                    $viewer = Auth::user();

                    $isAdmin = $viewer->role === 'admin';
                    $isModerator = $viewer->role === 'moderator';

                    $canSee =
                        $user->role === 'user'
                        || ($isAdmin && $user->role === 'moderator')
                        || ($isAdmin && $user->role === 'user')
                        || ($isModerator && $user->role === 'user');
                @endphp

                @continue(!$canSee)

                <tr class="{{ $user->status === 'inactive' ? 'text-secondary' : '' }}">

                    <td>{{ $users->firstItem() + $loop->index }}</td>

                    <td>
                        <div class="d-flex align-items-center gap-2">

                            <img src="{{ $user->avatar 
                                        ? asset('storage/'.$user->avatar) 
                                        : asset('images/avatar-placeholder.jpg') }}"
                                class="rounded-circle border"
                                width="42" height="42"
                                style="object-fit: cover;">

                            <div>
                                <div class="fw-bold">
                                    {{ $user->name }}
                                </div>

                                <small class="text-secondary">
                                    ID: {{ $user->id }}
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
                                <i class="fa-solid fa-crown me-1"></i> Admin
                            </span>

                        @elseif($user->role === 'moderator')
                            <span class="badge bg-warning text-dark">
                                <i class="fa-solid fa-shield-halved me-1"></i> Moderator
                            </span>

                        @else
                            <span class="badge bg-secondary">
                                <i class="fa-solid fa-user me-1"></i> User
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
                                Neaktīvs
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1 flex-nowrap">

                            <button type="button"
                                class="btn btn-sm btn-outline-light rounded"
                                data-bs-toggle="modal"
                                data-bs-target="#userModal{{ $user->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            @if(Auth::user()->role === 'admin')

                                <button type="button"
                                    class="btn btn-sm btn-outline-primary rounded"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                            @endif

                            @if(
                                Auth::user()->role === 'admin'
                                || (Auth::user()->role === 'moderator' && $user->role === 'user')
                            )

                                <form action="{{ $user->status === 'inactive'
                                    ? route(Auth::user()->role.'.users.activate', $user->id)
                                    : route(Auth::user()->role.'.users.deactivate', $user->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button class="btn btn-sm {{ $user->status === 'inactive'
                                        ? 'btn-outline-success'
                                        : 'btn-outline-warning' }} rounded">

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
                                    data-action="{{ route('moderator.users.destroy', $user->id) }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                            @endif

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center text-secondary py-5">
                        <i class="fa-solid fa-user-slash fa-3x mb-3 d-block"></i>
                        Nav lietotāju
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-3">
    {{ $users->links() }}
</div>