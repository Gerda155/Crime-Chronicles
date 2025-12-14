<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Crime Chronicles</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>
<body>
    <nav class="navbar navbar-dark px-4 d-flex justify-content-between">
        {{-- Левая часть --}}
        <div class="d-flex align-items-center gap-3">
            @auth
            {{-- Бургер --}}
            <button class="btn btn-outline-light" data-bs-toggle="offcanvas" data-bs-target="#burgerMenu">
                ☰
            </button>
            @endauth
        </div>

        {{-- Правая часть --}}
        <div class="d-flex align-items-center gap-3">
            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light">Pieteikties</a>
            <a href="{{ route('register') }}" class="btn btn-light">Reģistrēties</a>
            @endguest

            @auth
            {{-- Аватар --}}
            <img
                src="{{ Auth::user()->avatar 
                    ? asset('storage/' . Auth::user()->avatar) 
                    : asset('images/avatar-placeholder.jpg') }}"
                class="rounded-circle"
                width="40"
                height="40"
                style="object-fit: cover;"
                alt="Avatar">

            {{-- Приветствие --}}
            <span class="text-light">
                Sveiki, {{ Auth::user()->name }}!
            </span>

            {{-- Выход --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">
                    Iziet
                </button>
            </form>
            @endauth
        </div>
    </nav>

    @auth
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="burgerMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Izvēlne</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <a href="{{ route('cases.index') }}" class="d-block mb-2 text-light">Visas lietas</a>

        </div>
    </div>
    @endauth

  <main class="d-flex flex-column justify-content-center align-items-center text-center">
    <div class="logo mb-4">Crime Chronicles</div>

    <p class="disclaimer">
      Visi personāži, notikumi un lietas šajā projektā ir izdomāti. 
      Jebkādas sakritības ar reāliem cilvēkiem vai notikumiem ir nejaušas.
    </p>

    <a href="{{ url('/cases') }}" class="btn btn-lg btn-danger px-5">Skatīt visas lietas</a>
  </main>
</body>
</html>
