<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sasniegumi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="text-light">
    @include('partials.header')
    @include('partials.burger')

    <div class="container my-5">
        <h1 class="text-center mb-4">Sasniegumi</h1>

        <div class="row g-4">
            @foreach($achievements as $achievement)
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-dark border-secondary h-100 shadow-sm text-center p-4">

                        <img
                            src="{{ $achievement->icon
                                ? asset('images/achievements/'.$achievement->icon)
                                : asset('images/achievements/default.png') }}"
                            class="mx-auto mb-3"
                            width="80"
                            height="80"
                            style="object-fit: contain;"
                        >

                        <h5 class="card-title">{{ $achievement->title }}</h5>

                        <p class="text-secondary mb-0">
                            {{ $achievement->description }}
                        </p>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('partials.footer')
</body>
</html>
