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
    {{-- HEADER --}}
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

    {{-- BURGER --}}
    @auth
    <div class="offcanvas offcanvas-start text-bg-dark" id="burgerMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Izvēlne</h5>
            <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <a href="{{ route('cases.index') }}" class="d-block text-light mb-2">
                Visas lietas
            </a>
        </div>
    </div>
    @endauth
    <div class="card bg-dark text-light p-4">
        <div class="text-center">
            <img src="{{ $user->avatar
            ? asset('storage/'.$user->avatar)
            : asset('images/avatar-placeholder.jpg') }}"
                class="rounded-circle mb-3"
                width="120" height="120">

            <h3>{{ $user->username }}</h3>
            <p class="text-muted">Reģistrēts: {{ $user->created_at->format('d.m.Y') }}</p>
        </div>

        <hr>

        <p><strong>Par mani:</strong><br>
            {{ $user->bio ?? 'Nav apraksta' }}
        </p>

        <p><strong>Sasniegumi:</strong></p>
        <ul>
            @forelse($user->achievements as $ach)
            <li>{{ $ach->title }}</li>
            @empty
            <li>Nav sasniegumu</li>
            @endforelse
        </ul>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input name="username" class="form-control mb-2" required value="{{ $user->username }}">
        <input name="email" type="email" class="form-control mb-2" required value="{{ $user->email }}">

        <textarea name="bio" class="form-control mb-2" maxlength="300">
        {{ $user->bio }}
        </textarea>

        <input type="file" name="avatar" class="form-control mb-2">

        <input type="password" name="password" class="form-control mb-2" placeholder="Jauna parole">
        <input type="password" name="password_confirmation" class="form-control mb-2" placeholder="Apstiprināt paroli">

        <button class="btn btn-success">Saglabāt izmaiņas</button>
    </form>


    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <input type="password" name="password" class="form-control mb-2"
            placeholder="Ievadi paroli apstiprināšanai" required>

        <button class="btn btn-danger">
            Dzēst profilu
        </button>
    </form>


    </main>
</body>

</html>