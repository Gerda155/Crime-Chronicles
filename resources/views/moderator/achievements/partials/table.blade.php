        <div class="table-responsive rounded shadow-sm">

            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="table-dark text-uppercase text-muted small">
                    <tr>
                        <th>#</th>
                        <th><i class="fa-solid fa-trophy me-1"></i>Nosaukums</th>
                        <th><i class="fa-solid fa-align-left me-1"></i>Apraksts</th>
                        <th><i class="fa-solid fa-image me-1"></i>Ikona</th>
                        <th><i class="fa-solid fa-star me-1"></i> Nepieciešamās lietas</th>
                        <th><i class="fa-solid fa-toggle-on me-1"></i>Statuss</th>
                        <th><i class="fa-solid fa-calendar me-1"></i>Izveidots</th>
                        <th><i class="fa-solid fa-gear me-1"></i>Darbības</th>
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
                            <span class="badge bg-warning text-dark">
                                {{ $achievement->required_cases }}
                            </span>
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
                                22.11.26
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

                            <i class="fa-solid fa-trophy fa-3x mb-3 d-block"></i>

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