<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard - Stats</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-5 fw-bold text-pink">Moderatora statistika</h1>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card text-dark bg-info p-3 shadow-sm text-center">
                    <h5>Kopējais lietu skaits</h5>
                    <h2 class="fw-bold">{{ $totalCases }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-success p-3 shadow-sm text-center">
                    <h5>Aktīvās lietas</h5>
                    <h2 class="fw-bold">{{ $activeCases }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-warning p-3 shadow-sm text-center">
                    <h5>Kopējais lietotāju skaits</h5>
                    <h2 class="fw-bold">{{ $totalUsers }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-info p-3 shadow-sm text-center">
                    <h5>Aktīvie lietotāji</h5>
                    <h2 class="fw-bold">{{ $activeUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm bg-dark text-light">
                    <h5 class="text-center mb-3">Lietas pēc žanriem</h5>
                    <canvas id="casesByGenreChart" height="300"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm bg-dark text-light">
                    <h5 class="text-center mb-3">Lietotāji pēc statusa</h5>
                    <canvas id="usersStatusChart" height="300"></canvas>
                </div>
            </div>

            <div class="col-md-12 mt-4">
                <div class="card p-3 shadow-sm bg-dark text-light">
                    <h5 class="text-center mb-3">Jaunu reģistrāciju aktivitāte (7 dienas)</h5>
                    <canvas id="registrationsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script id="stats-data" type="application/json">
        {
            !!json_encode([
                'casesLabels' => $casesByGenre['labels'],
                'casesData' => $casesByGenre['data'],
                'activeUsers' => $activeUsers,
                'inactiveUsers' => $totalUsers - $activeUsers,
                'regLabels' => $regLabels,
                'regData' => $regData,
            ]) !!
        }
    </script>

    <script src="{{ asset('js/stats/charts.js') }}"></script>

</body>

</html>