<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Crime Chronicles</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>
<body>

  <nav class="navbar navbar-dark px-4">
    <div class="ms-auto">
      @guest
        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Pieteikties</a>
        <a href="{{ route('register') }}" class="btn btn-light">Reģistrēties</a>
      @endguest
    </div>
  </nav>

  <main class="d-flex flex-column justify-content-center align-items-center text-center">
    <div class="logo mb-4">Crime Chronicles</div>

    <p class="disclaimer">
      Visi personāži, notikumi un lietas šajā projektā ir izdomāti. 
      Jebkādas sakritības ar reāliem cilvēkiem vai notikumiem ir nejaušas.
    </p>

    <a href="{{ url('/cases') }}" class="btn btn-lg btn-danger px-5">Skatīt visas lietas</a>
  </main>
</body>
</html>
