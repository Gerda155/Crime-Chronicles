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
    @include('partials.header')
    @include('partials.burger')
    
    <main class="container my-5">
        <div class="row g-4">

            {{-- Profile --}}
            <div class="col-lg-4">
                <div class="card bg-dark text-light shadow-lg border-0">
                    <div class="card-body d-flex flex-column align-items-center text-center">

                        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/avatar-placeholder.jpg') }}"
                            class="rounded-circle mb-3 border border-secondary"
                            width="250" height="250"
                            style="object-fit: cover;">

                        <h4 class="mb-0">{{ $user->username }}</h4>
                        <small class="text-muted">
                            Reģistrēts: {{ $user->created_at->format('d.m.Y') }}
                        </small>

                        <hr class="border-secondary">

                        <p class="small">
                            {{ $user->bio ?: 'Nav apraksta' }}
                        </p>

                        <h6 class="text-uppercase text-muted mt-4">Sasniegumi</h6>
                        <ul class="list-unstyled small">
                            @forelse($user->achievements as $ach)
                            <li>🏆 {{ $ach->title }}</li>
                            @empty
                            <li class="text-muted">Nav sasniegumu</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- REDIĢĒŠANA --}}
            <div class="col-lg-8">
                <div class="card bg-dark text-light shadow-lg border-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Pilnais vārds</label>
                                    <input name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Lietotājvārds</label>
                                    <input name="username" class="form-control"
                                        value="{{ $user->username }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">E-pasts</label>
                                    <input name="email" type="email" class="form-control"
                                        value="{{ $user->email }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Par mani</label>
                                    <textarea name="bio" class="form-control" maxlength="300"
                                        rows="3">{{ $user->bio }}</textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Avatars</label>
                                    <input type="file" name="avatar" class="form-control">
                                </div>


                                <h5 class="mb-4">Profila iestatījumi</h5>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif


                                <div class="col-md-6">
                                    <label class="form-label">Jauna parole</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Apstiprināt paroli</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <button class="btn btn-success mt-4">
                                Saglabāt izmaiņas
                            </button>
                        </form>
                    </div>
                </div>

                {{-- DZĒŠANA --}}
                <div class="card bg-danger bg-opacity-10 border border-danger mt-4">
                    <div class="card-body">
                        <h6 class="text-danger">Bīstama zona</h6>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <input type="password" name="password"
                                class="form-control mb-3"
                                placeholder="Ievadi paroli apstiprināšanai" required>

                            <button class="btn btn-danger w-100">
                                Dzēst profilu
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>
@include('partials.footer')

</body>

</html>