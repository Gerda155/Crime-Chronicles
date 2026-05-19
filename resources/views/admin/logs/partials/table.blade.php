<div class="table-responsive rounded shadow-sm">
    <table class="table table-dark table-hover align-middle mb-0">
        <thead class="table-dark text-uppercase text-muted small">

            <tr>
                <th>#</th>
                <th>Lietotājs</th>
                <th>Darbība</th>
                <th>Objekts</th>
                <th>Objekta ID</th>
                <th>IP adrese</th>
                <th>Datums</th>
            </tr>

        </thead>

        <tbody>

            @forelse($logs as $log)

            <tr>

                <td>{{ $log->id }}</td>

                <td class="fw-bold">
                    {{ $log->username }}
                </td>

                <td>

                    @switch($log->action_type)

                    @case('login')

                    <span class="badge bg-success">
                        <i class="fa-solid fa-right-to-bracket me-1"></i>
                        Login
                    </span>

                    @break

                    @case('logout')

                    <span class="badge bg-secondary">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>
                        Logout
                    </span>

                    @break

                    @case('create')

                    <span class="badge bg-primary">
                        <i class="fa-solid fa-plus me-1"></i>
                        Create
                    </span>

                    @break

                    @case('update')

                    <span class="badge bg-warning text-dark">
                        <i class="fa-solid fa-pen me-1"></i>
                        Update
                    </span>

                    @break

                    @case('delete')

                    <span class="badge bg-danger">
                        <i class="fa-solid fa-trash me-1"></i>
                        Delete
                    </span>

                    @break

                    @case('approve')

                    <span class="badge bg-success">
                        <i class="fa-solid fa-check me-1"></i>
                        Approve
                    </span>

                    @break

                    @case('reject')

                    <span class="badge bg-danger">
                        <i class="fa-solid fa-xmark me-1"></i>
                        Reject
                    </span>

                    @break

                    @default

                    <span class="badge bg-light text-dark">
                        {{ ucfirst($log->action_type) }}
                    </span>

                    @endswitch

                </td>

                <td>
                    {{ ucfirst($log->object_type) }}
                </td>

                <td>
                    {{ $log->object_id ?? '-' }}
                </td>

                <td>
                    <small>
                        {{ $log->ip_address }}
                    </small>
                </td>

                <td>
                    <small>
                        {{ $log->created_at->format('d.m.Y H:i') }}
                    </small>
                </td>

            </tr>

           
            @empty

            <tr>

                <td colspan="8"
                    class="text-center text-secondary py-5">

                    Žurnāla ierakstu nav

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>