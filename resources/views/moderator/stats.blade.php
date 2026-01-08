<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderatora statistika</title>

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
    {!! json_encode([
        'casesLabels' => $casesByGenre['labels'],
        'casesData' => $casesByGenre['data'],
        'activeUsers' => $activeUsers,
        'inactiveUsers' => $totalUsers - $activeUsers,
        'regLabels' => $regLabels,
        'regData' => $regData,
    ]) !!}
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const raw = document.getElementById('stats-data');
            if (!raw) {
                console.error('stats-data not found');
                return;
            }

            const stats = JSON.parse(raw.textContent);

            const createChart = (ctx, config) => {
                if (!ctx) return;
                new Chart(ctx, config);
            };

            createChart(
                document.getElementById('casesByGenreChart')?.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: stats.casesLabels,
                        datasets: [{
                            label: 'Skaits',
                            data: stats.casesData,
                            backgroundColor: 'rgba(180, 80, 255, 0.6)',
                            borderColor: 'rgba(180, 80, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            );

            createChart(
                document.getElementById('usersStatusChart')?.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Aktīvie', 'Neaktīvie'],
                        datasets: [{
                            label: 'Lietotāji',
                            data: [stats.activeUsers, stats.inactiveUsers],
                            backgroundColor: [
                                'rgba(0, 220, 170, 0.7)',
                                'rgba(255, 90, 90, 0.7)'
                            ],
                            borderColor: [
                                'rgba(0, 220, 170, 1)',
                                'rgba(255, 90, 90, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            );

            createChart(
                document.getElementById('registrationsChart')?.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: stats.regLabels,
                        datasets: [{
                            label: 'Jaunas reģistrācijas',
                            data: stats.regData,
                            fill: true,
                            backgroundColor: 'rgba(80, 160, 255, 0.2)',
                            borderColor: 'rgba(80, 160, 255, 1)',
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            );
        });
    </script>

</body>

</html>