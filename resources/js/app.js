import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('casesForm');
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');

    function updateUrl() {
        const params = new URLSearchParams(window.location.search);
        params.set('search', searchInput.value.trim());
        params.set('sort', sortSelect.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    }

    let debounceTimeout;
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(updateUrl, 300);
    });

    sortSelect.addEventListener('change', updateUrl);
});
