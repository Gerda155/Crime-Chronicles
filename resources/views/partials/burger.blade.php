@auth
<div class="offcanvas offcanvas-start text-bg-dark border-end border-secondary" id="burgerMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-purple">
            <i class="fa-solid fa-bars me-2"></i>
            Izvēlne
        </h5>

        <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <a href="{{ route('profile.edit') }}" class="d-block text-light mb-3 text-decoration-none">
            <i class="fa-solid fa-user me-2 text-purple"></i>
            Mans profils
        </a>

        <a href="{{ route('cases.index') }}" class="d-block text-light mb-3 text-decoration-none">
            <i class="fa-solid fa-folder-open me-2"></i>
            Visas lietas
        </a>

        <a href="{{ route('cases.my-cases') }}" class="d-block text-light mb-3 text-decoration-none">
            <i class="fa-solid fa-book me-2"></i>
            Manas lietas
        </a>

        <a href="{{ route('ratings.index') }}" class="d-block text-light mb-3 text-decoration-none">
            <i class="fa-solid fa-star me-2"></i>
            Mani vērtējumi
        </a>

        <a href="{{ route('leaderboard') }}" class="d-block text-light mb-3 text-decoration-none">
            <i class="fa-solid fa-trophy me-2"></i>
            Labākie detektīvi
        </a>

        <a href="{{ route('achievements.index') }}" class="d-block text-light mb-3 text-decoration-none">
            <i class="fa-solid fa-medal me-2"></i>
            Sasniegumi
        </a>

        @if(Auth::user()->role === 'moderator' || Auth::user()->role === 'admin')

        <div class="mb-3 mt-4">

            <span class="fw-bold text-uppercase small text-secondary">
                <i class="fa-solid fa-shield-halved me-2"></i>
                @if(Auth::user()->role === 'moderator')
                Moderatora panelis
                @elseif(Auth::user()->role === 'admin')
                Administratora panelis
                @endif
            </span>

            <div class="ms-3 mt-3">

                <a href="{{ route('moderator.stats') }}" class="d-block text-light mb-2 text-decoration-none">
                    <i class="fa-solid fa-chart-line me-2"></i>
                    Statistika
                </a>

                <a href="{{ route('moderator.cases.index') }}" class="d-block text-light mb-2 text-decoration-none">
                    <i class="fa-solid fa-folder-tree me-2"></i>
                    Lietas
                </a>

                <a href="{{ route('moderator.users.index') }}" class="d-block text-light mb-2 text-decoration-none">
                    <i class="fa-solid fa-users me-2"></i>
                    Lietotāji
                </a>

                <a href="{{ route('moderator.achievements.index') }}" class="d-block text-light mb-2 text-decoration-none">
                    <i class="fa-solid fa-award me-2"></i>
                    Sasniegumi
                </a>

                <a href="{{ route('moderator.genres.index') }}" class="d-block text-light mb-2 text-decoration-none">
                    <i class="fa-solid fa-masks-theater me-2"></i>
                    Žanri
                </a>

                <a href="{{ route('moderator.rangs.index') }}" class="d-block text-light mb-2 text-decoration-none">
                    <i class="fa-solid fa-ranking-star me-2"></i>
                    Rangi
                </a>

                @endif

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.logs.index') }}" class="d-block text-light mb-2 text-decoration-none">
                    <i class="fa-solid fa-file-alt me-2"></i>
                    Darbību žurnāls
                </a>
                @endif

            </div>
        </div>

        <form method="GET" action="{{ route('users.search') }}" class="mb-4 mt-4">

            <label class="form-label text-secondary small">
                <i class="fa-solid fa-magnifying-glass me-2"></i>
                Meklēt detektīvus
            </label>

            <input
                type="text"
                name="q"
                placeholder="Lietotājvārds..."
                class="form-control bg-dark text-light border-secondary"
                value="{{ request('q') }}">
        </form>

        <a href="{{ route('contacts') }}" class="d-block text-light mb-2 text-decoration-none">
            <i class="fa-solid fa-envelope me-2"></i>
            Kontakti
        </a>

    </div>
</div>
@endauth