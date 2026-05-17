<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard - Stats</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
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
                    <h2 class="fw-bold">{{ $totalCases ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-success p-3 shadow-sm text-center">
                    <h5>Aktīvās lietas</h5>
                    <h2 class="fw-bold">{{ $activeCases ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-warning p-3 shadow-sm text-center">
                    <h5>Kopējais lietotāju skaits</h5>
                    <h2 class="fw-bold">{{ $totalUsers ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-info p-3 shadow-sm text-center">
                    <h5>Aktīvie lietotāji</h5>
                    <h2 class="fw-bold">{{ $activeUsers ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm bg-dark text-light">
                    <h5 class="text-center mb-3">Lietas pēc žanriem</h5>
                    <canvas id="casesByGenreChart" height="300" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm bg-dark text-light">
                    <h5 class="text-center mb-3">Lietotāji pēc statusa</h5>
                    <canvas id="usersStatusChart" height="300" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <div class="col-md-12 mt-4">
                <div class="card p-3 shadow-sm bg-dark text-light">
                    <h5 class="text-center mb-3">Jaunu reģistrāciju aktivitāte (7 dienas)</h5>
                    <canvas id="registrationsChart" height="300" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <div id="stats-data"
        data-cases-labels='@json($casesByGenreData["labels"] ?? [])'
        data-cases-data='@json($casesByGenreData["data"] ?? [])'
        data-active-users="{{ $activeUsers ?? 0 }}"
        data-total-users="{{ $totalUsers ?? 0 }}"
        data-reg-labels='@json($regLabels ?? [])'
        data-reg-data='@json($regData ?? [])'
        style="display: none;">
    </div>

    <script>
        const statsElement = document.getElementById('stats-data');

        window.statsData = {
            casesLabels: JSON.parse(statsElement.dataset.casesLabels || '[]'),
            casesData: JSON.parse(statsElement.dataset.casesData || '[]'),
            activeUsers: parseInt(statsElement.dataset.activeUsers || 0),
            inactiveUsers: parseInt(statsElement.dataset.totalUsers || 0) - parseInt(statsElement.dataset.activeUsers || 0),
            regLabels: JSON.parse(statsElement.dataset.regLabels || '[]'),
            regData: JSON.parse(statsElement.dataset.regData || '[]')
        };

        console.log('Stats loaded:', window.statsData);
    </script>

    <script src="{{ asset('js/stats/charts.js') }}"></script>

</body>

</html>