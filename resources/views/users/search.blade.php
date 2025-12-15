<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lietotāju meklēšana</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="text-light">
    @include('partials.header')
    @include('partials.burger')

    <div class="container my-5">
        <h1 class="text-center mb-4">
            Lietotāju meklēšana
            @if($query)
                <span class="text-secondary">“{{ $query }}”</span>
            @endif
        </h1>

        @if($query === '')
            <p class="text-center text-secondary mb-2">
                Ievadi lietotājvārdu, lai sāktu meklēšanu.
            </p>
        @elseif($users->isEmpty())
            <p class="text-center text-secondary mb-2">
                Neviens lietotājs netika atrasts.
            </p>
        @else
            @php
                $user = $users->first();
            @endphp

            <div class="card bg-dark border-secondary shadow-sm mx-auto p-4" style="max-width: 800px;">
                <div class="d-flex gap-4 align-items-start">

                    {{-- AVATAR --}}
                    <img
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatar-placeholder.jpg') }}"
                        class="rounded-circle border border-secondary"
                        width="120"
                        height="120"
                        style="object-fit: cover;"
                    >

                    {{-- INFO --}}
                    <div class="flex-grow-1 text-white">
                        <h3 class="mb-1">{{ $user->name }}</h3>
                        <p class="mb-1">
                            {{ $user->bio ?? 'Lietotājs vēl nav pievienojis bio.' }}
                        </p>

                        <h5 class="mb-2 mt-3">Ačīvmenti</h5>
                        @if($user->achievements && $user->achievements->count())
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($user->achievements as $achievement)
                                    <span class="badge bg-secondary">
                                        {{ $achievement->title }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-white">
                                Nav nevienas ačīvmenta 😔
                            </p>
                        @endif
                        <p class="text-secondary mb-2" style="font-size: 0.9rem;">
                            Detektīvs kopš: {{ $user->created_at->format('d.m.Y') }}
                        </p>
                    </div>

                </div>
            </div>
        @endif
    </div>
    @include('partials.footer')
</body>
</html>
