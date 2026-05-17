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
                    Reitings
                </th>

                <th>
                    <i class="fa-solid fa-graduation-cap me-1"></i>
                    Tutorial
                </th>

                <th>
                    <i class="fa-solid fa-toggle-on me-1"></i>
                    Statuss
                </th>

                <th>
                    <i class="fa-solid fa-calendar me-1"></i>
                    Izveidots
                </th>

                <th>
                    <i class="fa-solid fa-gear me-1"></i>
                    Darbības
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($cases as $case)

            <tr class="{{ $case->status === 'inactive' ? 'text-secondary' : '' }}">

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

                    @if($case->is_tutorial)

                    <span class="badge bg-info">
                        <i class="fa-solid fa-check me-1"></i>
                        Tutorial
                    </span>

                    @else

                    <span class="text-secondary">
                        —
                    </span>

                    @endif

                </td>

                <td>

                    @if($case->status === 'active')
                    <span class="badge bg-success">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        Aktīva
                    </span>

                    @elseif($case->status === 'pending')
                    <span class="badge bg-warning">
                        <i class="fa-solid fa-clock me-1"></i>
                        Gaida
                    </span>

                    @elseif($case->status === 'rejected')
                    <span class="badge bg-danger">
                        <i class="fa-solid fa-times-circle me-1"></i>
                        Noraidīta
                    </span>
                    @endif

                </td>

                <td>
                    <small>
                        {{ $case->created_at->format('d.m.Y') }}
                    </small>
                </td>

                <td>
                    <div class="d-flex gap-1 flex-nowrap">
                        <button type="button"
                            class="btn btn-sm {{ $case->is_tutorial ? 'btn-success' : 'btn-outline-info' }} rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#tutorialModal"
                            data-action="{{ route('moderator.cases.setTutorial', $case->id) }}"
                            title="Tutorial">

                            <i class="fa-solid fa-graduation-cap"></i>
                        </button>

                        <a href="{{ route('moderator.cases.edit', $case->id) }}"
                            class="btn btn-sm btn-outline-primary rounded"
                            title="Rediģēt">

                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form action="{{ $case->status === 'inactive'
                            ? route('moderator.cases.activate', $case->id)
                            : route('moderator.cases.deactivate', $case->id) }}"
                            method="POST">

                            @csrf
                            @method('PUT')

                            <button type="submit"
                                class="btn btn-sm {{ $case->status === 'inactive' ? 'btn-outline-success' : 'btn-outline-warning' }} rounded"
                                title="{{ $case->status === 'inactive' ? 'Aktivēt' : 'Deaktivēt' }}">

                                @if($case->status === 'inactive')
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
                            data-action="{{ route('moderator.cases.destroy', $case->id) }}"
                            title="Dzēst">

                            <i class="fa-solid fa-trash"></i>
                        </button>

                        @if($case->trashed())

                        <form action="{{ route('moderator.cases.restore', $case->id) }}"
                            method="POST">

                            @csrf

                            <button class="btn btn-sm btn-outline-success rounded"
                                title="Atjaunot">

                                <i class="fa-solid fa-rotate-left"></i>
                            </button>

                        </form>

                        @endif
                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center text-secondary py-5">

                    <i class="fa-solid fa-folder-open fa-3x mb-3 d-block"></i>

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