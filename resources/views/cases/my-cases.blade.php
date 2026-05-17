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

        <h1 class="text-center mb-4 fw-bold">
            <i class="fa-solid fa-folder-open me-2"></i>
            Manas lietas
        </h1>

        @include('cases.partials.my-cases.stats')
        @include('cases.partials.my-cases.filters')

        @if(session('status'))
        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info me-2"></i>
            {{ session('status') }}
        </div>
        @endif

        @include('cases.partials.my-cases.table')
        
    </main>

    @include('partials.footer')
    @include('cases.partials.my-cases.delete-modal')

</body>

</html>