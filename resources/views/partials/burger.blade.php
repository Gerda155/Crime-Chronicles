@auth
<div class="offcanvas offcanvas-start text-bg-dark" id="burgerMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Izvēlne</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <a href="{{ route('profile.edit') }}" class="d-block text-light mb-2">Mans profils</a>

        <a href="{{ route('cases.index') }}" class="d-block text-light mb-2">Visas lietas</a>

        <a href="{{ route('cases.my-cases') }}" class="d-block text-light mb-2">Manas lietas</a>

        <a href="{{ route('leaderboard') }}" class="d-block text-light mb-2">Labākie detektīvi</a>

        <a href="{{ route('achievements.index') }}" class="d-block text-light mb-2">Sasniegumi</a>

        @if(Auth::user()->role === 'moderator')
            <a href="{{ route('leaderboard') }}" class="d-block text-light mb-2">
                Dashboard (Moderator)
            </a>
        @endif

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('leaderboard') }}" class="d-block text-light mb-2">
                Dashboard (Admin)
            </a>
        @endif

        <form method="GET" action="{{ route('users.search') }}" class="mb-3">
            <p>Meklēt detektīvus pēc sēgvārda:</p>
            <input
                type="text"
                name="q"
                class="form-control bg-dark text-light border-secondary"
                value="{{ request('q') }}">
        </form>
    </div>
</div>
@endauth
