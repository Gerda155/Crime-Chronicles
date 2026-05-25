<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Rangs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            Moderatora panelis - Rangi
        </h1>

        @include('moderator.rangs.partials.stats')

        @include('moderator.rangs.partials.filters')

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
        @endif

        @include('moderator.rangs.partials.table')

    </main>

    @include('partials.footer')

    @include('moderator.rangs.partials.modals.create')
    @include('moderator.rangs.partials.modals.delete')

    @php
    $modalId = session('open_modal');
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modalId = '{{ $modalId }}';

            if (modalId && modalId !== '') {
                const modalEl = document.getElementById(modalId);

                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            }

        });
    </script>
</body>

</html>