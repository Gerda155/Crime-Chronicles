<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visas lietas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
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
  
    <div class="container my-5">
        <h1 class="mb-4 text-center">Visas lietas</h1>

        <div class="row search-sort g-3">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Meklēt pēc nosaukuma...">
            </div>
            <div class="col-md-6">
                <select id="sortSelect" class="form-select">
                    <option value="">Kārtot pēc...</option>
                    <option value="jauna">Jauna</option>
                    <option value="procesa">Procesā</option>
                    <option value="pabeigta">Pabeigta</option>
                </select>
            </div>
        </div>

        <div class="row g-4" id="casesContainer">
            <div class="col-md-6 col-lg-4 case-card" data-title="Lieta №1" data-status="procesa">
                <div class="card p-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Lieta №1</h5>
                        <span class="status-badge status-izpildes">Procesā</span>
                    </div>
                    <p class="card-text">Pārbaudīt pierādījumus no notikuma vietas.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 case-card" data-title="Lieta №2" data-status="jauna">
                <div class="card p-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Lieta №2</h5>
                        <span class="status-badge status-jauna">Jauna</span>
                    </div>
                    <p class="card-text">Noteikt aizdomās turamo personu.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 case-card" data-title="Lieta №3" data-status="pabeigta">
                <div class="card p-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Lieta №3</h5>
                        <span class="status-badge status-pabeigta">Pabeigta</span>
                    </div>
                    <p class="card-text">Analizēt kameru ierakstus.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 case-card" data-title="Lieta №4" data-status="procesa">
                <div class="card p-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Lieta №4</h5>
                        <span class="status-badge status-izpildes">Procesā</span>
                    </div>
                    <p class="card-text">Intervēt lieciniekus.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header">
            <h5 class="modal-title" id="authModalLabel">Uzmanību!</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Lai atklātu noziedznieku, Jums nepieciešams reģistrēties.
          </div>
          <div class="modal-footer">
            <a href="{{ route('login') }}" class="btn btn-danger">Pieteikties</a>
            <a href="{{ route('register') }}" class="btn btn-light">Reģistrēties</a>
          </div>
        </div>
      </div>
    </div>

</body>
</html>
