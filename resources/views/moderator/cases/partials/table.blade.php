<div class="table-responsive rounded shadow-sm">
    <table class="table table-dark table-hover align-middle mb-0">
        <thead class="table-dark text-uppercase text-muted small">
            <tr>
                <th>#</th>
                <th>Autors</th>
                <th>Nosaukums</th>
                <th>Apraksts</th>
                <th>Žanrs</th>
                <th>Reitings</th>
                <th>Tutorial </th>
                <th>Izveidots</th>
                <th>Statuss</th>
                <th>Dzēst</th>
            </tr>
        </thead>

        <tbody>

            @forelse($cases as $case)

            <tr class="{{ $case->status === 'inactive' ? 'text-secondary' : '' }}">
                
                <td>{{ $case->id }}</td>

                <td>
                    {{ Str::limit($case->user->username ?? '—', 25) }}
                </td>

                <td class="fw-bold">
                    {{ $case->title }}
                </td>

                <td>
                    {{ Str::limit($case->description, 30) }}
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
                    @if($case->is_tutorial)
                    <span class="badge bg-info">
                        <i class="fa-solid fa-check me-1"></i>
                        Tutorial
                    </span>
                    @else

                    <form action="{{ route('moderator.cases.setTutorial', $case->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')

                        <button type="button" data-bs-toggle="modal" data-bs-target="#tutorialModal"
                            data-action="{{ route('moderator.cases.setTutorial', $case->id) }}" class="btn btn-sm btn-outline-info rounded" title="Iestatīt kā tutorial">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </form>

                    @endif
                </td>

                <td>
                    <small>
                        {{ $case->created_at->format('d.m.Y') }}
                    </small>
                </td>

                <td>
                    <div class="dropdown">

                        <button
                            class="btn btn-sm rounded-pill px-3
                            @if($case->status === 'active')
                                btn-success

                            @elseif($case->status === 'pending')
                                btn-warning text-dark

                            @elseif($case->status === 'approved')
                                btn-info text-dark

                            @elseif($case->status === 'rejected')
                                btn-danger

                            @elseif($case->status === 'inactive')
                                btn-secondary

                            @else
                                btn-dark
                            @endif

                            dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            @if($case->status === 'active')
                            <i class="fa-solid fa-circle-check me-1"></i>
                            Aktīva

                            @elseif($case->status === 'pending')
                            <i class="fa-solid fa-clock me-1"></i>
                            Gaida

                            @elseif($case->status === 'approved')
                            <i class="fa-solid fa-shield-check me-1"></i>
                            Apstiprināta

                            @elseif($case->status === 'rejected')
                            <i class="fa-solid fa-circle-xmark me-1"></i>
                            Noraidīta

                            @elseif($case->status === 'inactive')
                            <i class="fa-solid fa-ban me-1"></i>
                            Neaktīva
                            @endif
                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark shadow border-0">

                            @if($case->status === 'pending')

                            <li>
                                <form action="{{ route('moderator.cases.approve', $case) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="dropdown-item text-info">
                                        Apstiprināt
                                    </button>
                                </form>
                            </li>

                            <li>
                                <button class="dropdown-item text-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal"
                                    data-action="{{ route('moderator.cases.reject', $case) }}">
                                    Noraidīt
                                </button>
                            </li>

                            @endif


                            @if(in_array($case->status, ['approved', 'rejected']))

                            <li>
                                <form action="{{ route('moderator.cases.reset', $case) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="dropdown-item text-warning">
                                        Atgriezt uz gaidīšanu
                                    </button>
                                </form>
                            </li>

                            @endif


                            @if($case->status === 'active')
                            <li>
                                <form action="{{ route('moderator.cases.deactivate', $case) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="dropdown-item text-warning">
                                        Deaktivēt
                                    </button>
                                </form>
                            </li>

                            <li>
                                <form action="{{ route('moderator.cases.reset', $case) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="dropdown-item text-warning">
                                        Atgriezt uz gaidīšanu
                                    </button>
                                </form>
                            </li>
                            @endif


                            @if(in_array($case->status, ['inactive', 'approved']))
                            <li>
                                <form action="{{ route('moderator.cases.activate', $case) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="dropdown-item text-success">
                                        Aktivēt
                                    </button>
                                </form>
                            </li>
                            @endif

                        </ul>
                    </div>
                </td>

                <td>
                    <button type="button"
                        class="btn btn-sm btn-outline-danger rounded"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-action="{{ route('moderator.cases.destroy', $case->id) }}"
                        title="Dzēst">

                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>

            </tr>
            @empty
            <tr>

                <td colspan="9" class="text-center text-secondary py-5">
                    Nav izveidotu lietu
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $cases->links() }}
</div>