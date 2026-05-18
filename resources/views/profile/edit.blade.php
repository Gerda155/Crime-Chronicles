<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/profile/avatar-cropper.js') }}" defer></script>
</head>

<body>
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <div class="row g-4">

            <div class="col-lg-4">
                @include('profile.partials.profile-card')
            </div>

            <div class="col-lg-8">
                <div class="card bg-dark text-light shadow-lg border-0">
                    <div class="card-body">
                        <h5 class="mb-4">Profila iestatījumi</h5>

                        @include('partials.alerts')

                        @include('profile.partials.profile-form')
                    </div>
                </div>

                @include('profile.partials.delete-account')

            </div>
        </div>
    </main>

    @include('partials.footer')

</body>

</html>