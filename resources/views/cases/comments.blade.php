<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold">Komentāri par lietu: {{ $case->title }}</h1>

        <a href="{{ route('cases.my-cases') }}" class="btn btn-outline-light mb-3">
            <i class="fa-solid fa-circle-arrow-left"></i> Atpakaļ
        </a>

        @forelse($case->ratings as $rating)
        <div class="card bg-secondary text-light mb-2 p-2">
            <strong>{{ $rating->user->name }}</strong>

            <div>
                Rating: {{ $rating->rating }}/5
            </div>

            <p>{{ $rating->comment }}</p>

            <small class="text-muted">
                {{ $rating->created_at }}
            </small>
        </div>
        @empty
        <p>Nav atsauksmju</p>
        @endforelse
    </main>

    @include('partials.footer')

</body>

</html>