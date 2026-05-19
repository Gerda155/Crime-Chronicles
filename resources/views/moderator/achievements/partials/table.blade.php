        <div class="table-responsive rounded shadow-sm">

            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="table-dark text-uppercase text-muted small">
                    <tr>
                        <th>#</th>
                        <th>Nosaukums</th>
                        <th>Apraksts</th>
                        <th>Ikona</th>
                        <th>Nepieciešamās lietas</th>
                        <th>Statuss</th>
                        <th>Izveidots</th>
                        <th>Darbības</th>
                    </tr>

                </thead>

                <tbody>
                    @forelse($achievements as $achievement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-bold">
                            {{ $achievement->title }}
                        </td>

                        <td>
                            {{ Str::limit($achievement->description, 60) }}
                        </td>

                        <td>
                            <img src="{{ $achievement->icon ? asset('storage/'.$achievement->icon) : asset('storage/achievements/default.png') }}"
                                width="70"
                                height="70"
                                class="rounded"
                                style="object-fit: cover;">
                        </td>

                        <td>
                            {{ $achievement->required_cases }}
                        </td>

                        <td>

                            @if($achievement->status === 'active')

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
                            <small>
                                {{ $achievement->created_at->format('d.m.Y') }}
                            </small>
                        </td>

                        <td>
                            <div class="d-flex gap-1 flex-nowrap">
                                <button class="btn btn-sm btn-outline-primary rounded"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAchievementModal{{ $achievement->id }}"
                                    title="Rediģēt">

                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                @if($achievement->deleted_at)

                                <form action="{{ route('moderator.achievements.restore', $achievement->id) }}"
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
                                    data-action="{{ route('moderator.achievements.destroy', $achievement->id) }}"
                                    title="Dzēst">

                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                @if($achievement->status === 'active')

                                <form action="{{ route('moderator.achievements.deactivate', $achievement->id) }}"
                                    method="POST">

                                    @csrf

                                    <button type="submit"
                                        class="btn btn-sm btn-outline-warning rounded"
                                        title="Deaktivēt">

                                        <i class="fa-solid fa-ban"></i>
                                    </button>

                                </form>

                                @else

                                <form action="{{ route('moderator.achievements.activate', $achievement->id) }}"
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

                            </div>
                        </td>

                    </tr>

                    @include('moderator.achievements.partials.modals.edit', ['achievement' => $achievement])

                    @empty

                    <tr>
                        <td colspan="8" class="text-center text-secondary py-5">
                            Nav izveidotu sasniegumu
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="mt-4">
            {{ $achievements->links() }}
        </div>