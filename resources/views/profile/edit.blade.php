<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visas lietas</title>

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

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-gray-900 text-white rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold mb-6">Mans profils</h1>

    @if(session('success'))
        <div class="mb-4 p-2 bg-green-700 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label>Vārds lietotājam</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full p-2 rounded bg-gray-800 text-white">
            @error('username') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>E-pasts</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-2 rounded bg-gray-800 text-white">
            @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Parole</label>
            <input type="password" name="password" class="w-full p-2 rounded bg-gray-800 text-white">
            @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Apstiprināt paroli</label>
            <input type="password" name="password_confirmation" class="w-full p-2 rounded bg-gray-800 text-white">
        </div>

        <div>
            <label>Bio</label>
            <textarea name="bio" class="w-full p-2 rounded bg-gray-800 text-white">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div>
            <label>Profila bilde</label>
            <input type="file" name="avatar" class="w-full p-2 rounded bg-gray-800 text-white">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-32 h-32 rounded-full mt-2">
            @endif
        </div>

        <button type="submit" class="bg-pink-600 px-4 py-2 rounded hover:bg-pink-700">Saglabāt izmaiņas</button>
    </form>

    <hr class="my-6 border-gray-700">

    <h2 class="text-2xl font-bold mb-4">Sasniegumi</h2>
    <ul class="list-disc pl-6">
        @foreach($user->achievements as $ach)
            <li>{{ $ach->title }} - {{ $ach->description }}</li>
        @endforeach
    </ul>

    <form action="{{ route('profile.destroy') }}" method="POST" class="mt-6">
        @csrf
        @method('DELETE')
        <label>Ievadi savu paroli, lai dzēstu profilu</label>
        <input type="password" name="password" class="w-full p-2 rounded bg-gray-800 text-white mb-2">
        <button type="submit" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">Dzēst profilu</button>
    </form>
</div>
@endsection

</body>
</html>

    