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
        document.getElementById('casesByGenreChart')?.getContext('2d'),
        {
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
        document.getElementById('usersStatusChart')?.getContext('2d'),
        {
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
        document.getElementById('registrationsChart')?.getContext('2d'),
        {
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