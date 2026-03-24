<nav class="navbar navbar-dark px-4 d-flex justify-content-between">
    <div>
        @auth
        <button class="btn btn-outline-light" data-bs-toggle="offcanvas" data-bs-target="#burgerMenu">
            ☰
        </button>
        @endauth
    </div>

    <div class="d-flex align-items-center gap-3">

        @guest
        <a href="{{ route('welcome') }}" class="btn btn-outline-light">Sākums</a>
        <a href="{{ route('contacts') }}" class="btn btn-outline-light">Kontakti</a>
        <a href="{{ route('login') }}" class="btn btn-outline-light">Pieteikties</a>
        <a href="{{ route('register') }}" class="btn btn-light">Reģistrēties</a>
        @endguest

        @auth
        <img
            src="{{ Auth::user()->avatar
                ? asset('storage/' . Auth::user()->avatar)
                : asset('images/avatar-placeholder.jpg') }}"
            class="rounded-circle"
            width="40"
            height="40"
            style="object-fit: cover;">

        <span class="text-light">
            Sveiki, {{ Auth::user()->name }}!
        </span>

        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Iziet
        </button>
        @endauth
    </div>
</nav>

<form id="logout-form" method="POST" action="/logout">
    @csrf
</form>

<div class="modal fade" id="logoutModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title">Apstiprinājums</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Vai tu tiešām vēlies iziet?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Atcelt</button>
                <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Iziet
                </button>
            </div>
        </div>
    </div>
</div>