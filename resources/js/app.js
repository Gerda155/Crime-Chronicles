import './bootstrap';

// Meklēšanas un kārtošanas funkcionalitāte
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const cases = document.querySelectorAll('.case-card');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        cases.forEach(card => {
            const title = card.dataset.title.toLowerCase();
            card.style.display = title.includes(query) ? '' : 'none';
        });
    });

    sortSelect.addEventListener('change', function() {
        const value = this.value;
        cases.forEach(card => {
            if(value === '') {
                card.style.display = '';
            } else {
                card.style.display = card.dataset.status === value ? '' : 'none';
            }
        });
    });
});