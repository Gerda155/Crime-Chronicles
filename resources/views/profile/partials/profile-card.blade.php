<div class="card bg-dark text-light shadow-lg border-0">
    <div class="card-body d-flex flex-column align-items-center text-center">

        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/avatar-placeholder.jpg') }}"
            class="rounded-circle mb-3 border border-secondary"
            width="250" height="250"
            style="object-fit: cover;">

        <h4 class="mb-0">{{ $user->rang->name ?? 'No rang' }} {{ $user->username }}</h4>

        <hr class="border-secondary">

        <p class="small">{{ $user->bio ?: 'Nav apraksta' }}</p>

        <div class="border-0 w-100 p-3">

            <div class="d-flex justify-content-between">
                <span>Punkti</span>
                <span>{{ $totalScore }}</span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Veiksmīgums</span>
                <span>{{ $successRate }}%</span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Kļūdas</span>
                <span>{{ $errorCount }}</span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Izveidoti gadījumi</span>
                <span>{{ $createdCases }}</span>
            </div>

        </div>

        <h6 class="text-uppercase card-text mt-4 mb-3">Sasniegumi</h6>

        <div class="d-flex flex-wrap gap-3 justify-content-center">
            @forelse($user->achievements as $ach)
            <div class="card bg-secondary text-dark text-center p-2" style="width: 120px;">
                <img src="{{ $ach->icon
                                    ? asset('storage/'.$ach->icon)
                                    : asset('storage/achievements/default.png') }}"
                    class="mb-2 mx-auto"
                    style="width: 50px; height: 50px; object-fit: contain;">
                <div class="small fw-bold">{{ $ach->title }}</div>
            </div>
            @empty
            <div class="text-secondary">Nav sasniegumu</div>
            @endforelse
        </div>

        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <h6 class="text-uppercase card-text mt-3 mb-3">Pabeigtie līmeņi: {{ $completedCount }}</h6>
        </div>
        <small class="text-secondary mb-2"> Detektīvs kopš: {{ $user->created_at->format('d.m.Y') }}</small>
    </div>
</div>