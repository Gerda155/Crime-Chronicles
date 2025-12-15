@auth
<div class="offcanvas offcanvas-start text-bg-dark" id="burgerMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Izvēlne</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <a href="{{ route('profile.edit') }}"">Mans profils</a>

        <a href=" {{ route('cases.index') }}" class="d-block text-light mb-2">
            Visas lietas
        </a>

        <form method=" GET" action="{{ route('users.search') }}" class="mb-3">
            <p>Meklēt detektīvus pēc sēgvārda:</p>
            <input
                type="text"
                name="q"
                class="form-control bg-dark text-light border-secondary"
                placeholder="Пошук за юзернеймом..."
                value="{{ request('q') }}">
        </form>
    </div>
</div>
@endauth