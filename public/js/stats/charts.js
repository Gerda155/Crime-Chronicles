document.addEventListener("DOMContentLoaded", () => {
    
    console.log('DOM loaded, checking Chart.js...');
    
    // Проверяем загрузился ли Chart.js
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded! Check the script source.');
        return;
    }
    
    console.log('Chart.js loaded successfully');
    
    // Проверяем наличие данных
    if (!window.statsData) {
        console.error('statsData not found!');
        return;
    }
    
    const stats = window.statsData;
    console.log('Stats data:', stats);
    
    // Функция создания графика
    function createChart(elementId, config) {
        const canvas = document.getElementById(elementId);
        if (!canvas) {
            console.error(`Canvas ${elementId} not found`);
            return null;
        }
        
        const ctx = canvas.getContext('2d');
        if (!ctx) {
            console.error(`Context for ${elementId} not available`);
            return null;
        }
        
        try {
            return new Chart(ctx, config);
        } catch (error) {
            console.error(`Error creating chart ${elementId}:`, error);
            return null;
        }
    }
    
    // График по жанрам
    if (stats.casesLabels && stats.casesLabels.length > 0) {
        createChart('casesByGenreChart', {
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
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
        console.log('Cases by genre chart created');
    } else {
        console.warn('No cases by genre data available');
    }
    
    // График статусов пользователей
    createChart('usersStatusChart', {
        type: 'bar',
        data: {
            labels: ['Aktīvie', 'Neaktīvie'],
            datasets: [{
                label: 'Lietotāji',
                data: [stats.activeUsers || 0, stats.inactiveUsers || 0],
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
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
    console.log('Users status chart created');
    
    // График регистраций
    if (stats.regLabels && stats.regLabels.length > 0) {
        createChart('registrationsChart', {
            type: 'line',
            data: {
                labels: stats.regLabels,
                datasets: [{
                    label: 'Jaunas reģistrācijas',
                    data: stats.regData,
                    fill: true,
                    backgroundColor: 'rgba(80, 160, 255, 0.2)',
                    borderColor: 'rgba(80, 160, 255, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(80, 160, 255, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
        console.log('Registrations chart created');
    } else {
        console.warn('No registration data available');
    }
});