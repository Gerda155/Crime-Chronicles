document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('achievementModal');

    if (!modal) return;

    new bootstrap.Modal(modal).show();
});