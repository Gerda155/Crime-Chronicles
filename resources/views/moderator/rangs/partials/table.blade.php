<div class="table-responsive rounded shadow-sm">

    <table class="table table-dark table-hover align-middle mb-0">

        <thead class="table-dark text-uppercase text-muted small">
            <tr>

                <th>#</th>

                <th>
                    <i class="fa-solid fa-ranking-star me-1"></i>
                    Nosaukums
                </th>

                <th>
                    <i class="fa-solid fa-arrow-down-1-9 me-1"></i>
                    Min punkti
                </th>

                <th>
                    <i class="fa-solid fa-arrow-up-9-1 me-1"></i>
                    Max punkti
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

            @forelse($rangs as $rang)

            <tr class="{{ $rang->status === 'inactive' ? 'text-secondary' : '' }}">

                <td>{{ $loop->iteration }}</td>

                <td class="fw-bold">
                    {{ $rang->name }}
                </td>

                <td>
                    {{ $rang->min_score }}
                </td>

                <td>
                    {{ $rang->max_score ?? '∞' }}
                </td>

                <td>
                    <small>
                        {{ $rang->created_at->format('d.m.Y') }}
                    </small>
                </td>

                <td>

                    @if($rang->status === 'active')

                    <span class="badge bg-success">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        Aktīvs
                    </span>

                    @else

                    <span class="badge bg-danger">
                        <i class="fa-solid fa-xmark me-1"></i>
                        Neaktīvs
                    </span>

                    @endif

                </td>

                <td class="d-flex flex-wrap gap-1">

                    <button class="btn btn-sm btn-outline-primary rounded"
                        data-bs-toggle="modal"
                        data-bs-target="#editRankModal{{ $rang->id }}"
                        title="Rediģēt">

                        <i class="fa-solid fa-pen"></i>

                    </button>

                    @if($rang->deleted_at)

                    <form action="{{ route('moderator.rangs.restore', $rang->id) }}"
                        method="POST">

                        @csrf

                        <button type="submit"
                            class="btn btn-sm btn-outline-success rounded"
                            title="Atjaunot">

                            <i class="fa-solid fa-rotate-left"></i>

                        </button>

                    </form>

                    @else

                    <button type="button"
                        class="btn btn-sm btn-outline-danger rounded"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-action="{{ route('moderator.rangs.destroy', $rang->id) }}"
                        title="Dzēst">

                        <i class="fa-solid fa-trash"></i>

                    </button>

                    @if($rang->status === 'active')

                    <form action="{{ route('moderator.rangs.deactivate', $rang->id) }}"
                        method="POST">

                        @csrf

                        <button type="submit"
                            class="btn btn-sm btn-outline-warning rounded"
                            title="Deaktivēt">

                            <i class="fa-solid fa-ban"></i>
                        </button>

                    </form>

                    @else

                    <form action="{{ route('moderator.rangs.activate', $rang->id) }}"
                        method="POST">

                        @csrf

                        <button type="submit"
                            class="btn btn-sm btn-outline-success rounded"
                            title="Aktivēt">

                            <i class="fa-solid fa-toggle-on"></i>

                        </button>

                    </form>

                    @endif
                    @endif

                </td>

            </tr>

            @include('moderator.rangs.partials.modals.edit', ['rang' => $rang])

            @empty

            <tr>
                <td colspan="7" class="text-center text-secondary py-5">

                    <i class="fa-solid fa-ranking-star fa-3x mb-3 d-block"></i>

                    Nav izveidotu rangu

                </td>
            </tr>

            @endforelse

        </tbody>

    </table>
</div>

<div class="mt-4">
    {{ $rangs->links() }}
</div>