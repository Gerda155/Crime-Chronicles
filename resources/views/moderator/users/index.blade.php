<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Users</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center fw-bold mb-4">
            Moderatora panelis – Lietotāji
        </h1>

        @include('moderator.users.partials.stats')
        @include('moderator.users.partials.filters')

        @include('partials.alerts')

        @include('moderator.users.partials.table')

    </main>

    @include('partials.footer')

    @include('moderator.users.partials.modals.view')
    @include('moderator.users.partials.modals.edit')
    @include('moderator.users.partials.modals.create')
    @include('moderator.users.partials.modals.delete')

</body>

</html>