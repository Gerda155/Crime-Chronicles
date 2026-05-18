<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mani vērtējumi - Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/rating/rating-stars.js') }}" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            <i class="fa-solid fa-star me-2"></i>
            Mani vērtējumi
        </h1>

        @include('partials.alerts')

        <div class="row g-3">
            @forelse($ratings as $rating)

            @include('ratings.partials.rating_card')

            @include('ratings.partials.edit_modal')

            @include('ratings.partials.delete_modal')
            @empty

            <div class="text-center text-secondary py-5">
                <i class="fa-solid fa-star fa-3x mb-3 d-block"></i>
                Nav vērtējumu
            </div>

            @endforelse

        </div>

    </main>

    @include('partials.footer')

</body>

</html>