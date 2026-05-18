<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visas lietas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    @include('partials.header')
    @include('partials.burger')

    <div class=" container my-5">
        <h1 class="text-center mb-4 fw-bold">Visas lietas</h1>

        <div class="d-flex flex-wrap gap-2 mb-4">
            @include('cases.partials.filters')
        </div>

        <div class="row g-4">
            @forelse($cases as $case)

            @include('cases.partials.case_card', ['case' => $case])

            @auth

            @include('cases.partials.modals.case-modal', ['case' => $case])

            @endauth

            @empty
            <div class="col-12 text-center text-secondary my-5">
                <p>Nav nevienas aktīvas lietas, kas atbilst meklēšanas kritērijiem.</p>
            </div>
            @endforelse
        </div>


        <div class="mt-4">
            {{ $cases->links() }}
        </div>
    </div>

    @include('cases.auth.partials.auth-modal')
    @include('partials.footer')

</body>

</html>