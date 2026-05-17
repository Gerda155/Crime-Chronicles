<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Genres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

    <h1 class="text-center mb-4 fw-bold">
        Moderatora panelis - Žanri
    </h1>

    @include('moderator.genres.partials.stats')

    @include('moderator.genres.partials.filters')

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    @include('moderator.genres.partials.table')
</main>

    @include('moderator.genres.create-modal')

    @include('partials.footer')

    @include('moderator.genres.partials.modals')
</body>

</html>