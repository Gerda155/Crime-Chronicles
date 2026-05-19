@foreach($users as $user)

<div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-secondary">

            <div class="modal-header">
                <h5 class="modal-title">Lietotāja informācija</h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body d-flex gap-4">

                <img
                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatar-placeholder.jpg') }}"
                    class="rounded-circle border 
                    @if($user->role === 'moderator') border-warning 
                    @else border-secondary @endif"
                    width="200"
                    height="200"
                    style="object-fit: cover;">

                <div>

                    <h4>{{ $user->name }}</h4>

                    <p class="text-secondary">{{ $user->email }}</p>

                    <p>Role: <b>{{ $user->role }}</b></p>

                    <p>Bio: {{ $user->bio ?? '—' }}</p>

                    <p>Punkti: {{ $user->total_score ?? 0 }}</p>

                    <p>Pabeigtas lietas: {{ $user->completed_cases_count ?? 0 }}</p>

                    <p class="text-secondary">
                        Reģistrēts: {{ $user->created_at->format('d.m.Y') }}
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

@endforeach