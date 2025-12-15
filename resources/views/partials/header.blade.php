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

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger btn-sm">Iziet</button>
        </form>
        @endauth
    </div>
</nav>