<div class="table-responsive rounded shadow-sm">

    <table class="table table-dark table-hover align-middle mb-0">

        <thead class="table-dark text-uppercase text-muted small">
            <tr>
                <th>#</th>
                <th>Nosaukums</th>
                <th>Statuss</th>
                <th>Izveidots</th>
                <th>Darbības</th>
            </tr>
        </thead>

        <tbody>

            @forelse($genres as $genre)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td class="fw-bold">
                    {{ $genre->name }}
                </td>

                <td>

                    @if($genre->status === 'active')

                    <span class="badge bg-success">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        Aktīvs
                    </span>

                    @else

                    <span class="badge bg-danger">
                        <i class="fa-solid fa-ban me-1"></i>
                        Neaktīvs
                    </span>

                    @endif

                </td>

                <td>
                    <small>
                        {{ $genre->created_at->format('d.m.Y') }}
                    </small>
                </td>

                <td class="d-flex flex-wrap gap-1">

                    <button class="btn btn-sm btn-outline-primary rounded"
                        data-bs-toggle="modal"
                        data-bs-target="#editGenreModal{{ $genre->id }}"
                        title="Rediģēt">

                        <i class="fa-solid fa-pen"></i>
                    </button>

                    @if($genre->deleted_at)

                    <form action="{{ route('moderator.genres.restore', $genre->id) }}"
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
                        data-action="{{ route('moderator.genres.destroy', $genre->id) }}"
                        title="Dzēst">

                        <i class="fa-solid fa-trash"></i>
                    </button>

                    @if($genre->status === 'active')

                    <form action="{{ route('moderator.genres.deactivate', $genre->id) }}"
                        method="POST">

                        @csrf

                        <button type="submit"
                            class="btn btn-sm btn-outline-warning rounded"
                            title="Deaktivēt">

                            <i class="fa-solid fa-ban"></i>
                        </button>

                    </form>

                    @else

                    <form action="{{ route('moderator.genres.activate', $genre->id) }}"
                        method="POST">

                        @csrf

                        <button type="submit"
                            class="btn btn-sm btn-outline-success rounded"
                            title="Aktivēt">

                            <i class="fa-solid fa-check"></i>
                        </button>

                    </form>

                    @endif
                    @endif

                </td>

            </tr>

            @include('moderator.genres.partials.modals.edit', ['genre' => $genre])

            @empty

            <tr>
                <td colspan="5" class="text-center text-secondary py-5">
                    Nav izveidotu žanru
                </td>
            </tr>

            @endforelse

        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $genres->links() }}
</div>