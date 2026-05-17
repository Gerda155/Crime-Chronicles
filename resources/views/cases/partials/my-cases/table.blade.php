<div class="table-responsive rounded shadow-sm">
    <table class="table table-dark table-hover align-middle mb-0">
        <thead class="table-dark text-uppercase text-muted small">
            <tr>
                <th>#</th>
                <th><i class="fa-solid fa-folder me-1"></i>Nosaukums</th>

                <th><i class="fa-solid fa-align-left me-1"></i>Apraksts</th>

                <th><i class="fa-solid fa-masks-theater me-1"></i>Žanrs</th>

                <th><i class="fa-solid fa-star me-1"></i>Vērtējums</th>

                <th><i class="fa-solid fa-calendar me-1"></i>Izveidots</th>

                <th><i class="fa-solid fa-toggle-on me-1"></i>Statuss</th>

                <th><i class="fa-solid fa-gear me-1"></i>Darbības</th>
            </tr>
        </thead>

        <tbody>

            @forelse($cases as $case)

            <tr class="align-middle">

                <td>{{ $loop->iteration }}</td>

                <td class="fw-bold">{{ $case->title }}</td>

                <td>{{ Str::limit($case->description, 60) }}</td>

                <td>{{ $case->genre->name ?? '-' }}</td>

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
                    <small class="text-secondary">{{ number_format($case->rating ?? 0, 1) }}</small>
                </td>

                <td>
                    <small>{{ $case->created_at->format('d.m.Y') }}</small>
                </td>

                <td>

                    @if($case->status !== 'pending')

                    <form method="POST" action="{{ route('cases.toggle-status', $case->id) }}">
                        @csrf
                        @method('PATCH')
                        <button class="status-switch {{ $case->status === 'active' ? 'active' : '' }}" type="submit">
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

                    <a href="{{ route('cases.comments', $case->id) }}"
                        class="btn btn-sm btn-outline-info rounded"
                        title="Komentāri">
                        <i class="fa-solid fa-comments"></i>
                    </a>

                    <a href="{{ route('cases.edit', $case->id) }}"
                        class="btn btn-sm btn-outline-primary rounded"
                        title="Rediģēt">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <button type="button"
                        class="btn btn-sm btn-outline-danger rounded"
                        data-url="{{ route('cases.destroy', $case->id) }}"
                        data-title="{{ $case->title }}"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        title="Dzēst">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </td>
            </tr>

            @empty

            <tr>
                <td colspan="8" class="text-center text-secondary py-5">
                    <i class="fa-solid fa-folder-open fa-3x mb-3 d-block"></i> Nav izveidotu lietu
                </td>
            </tr>

            @endforelse

        </tbody>
    </table>
</div>