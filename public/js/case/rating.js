document.addEventListener('DOMContentLoaded', function () {

    const ratingModalEl = document.getElementById('ratingModal');

    if (!ratingModalEl) return;

    const ratingModal = new bootstrap.Modal(ratingModalEl);

    ratingModal.show();

    const stars = document.querySelectorAll('.rating-stars .star');

    let selectedValue = 0;

    stars.forEach(function (star) {

        const value = parseInt(star.dataset.value);

        star.addEventListener('mouseenter', function () {
            highlightStars(value);
        });

        star.addEventListener('mouseleave', function () {
            highlightStars(selectedValue);
        });

        star.addEventListener('click', function () {
            selectedValue = value;
            star.querySelector('input').checked = true;
            highlightStars(selectedValue);
        });
    });

    function highlightStars(rating) {

        stars.forEach(function (star) {

            const value = parseInt(star.dataset.value);

            star.style.color = value <= rating
                ? '#ffc107'
                : '#555';
        });
    }

    const form = document.getElementById('ratingForm');

    if (!form) return;

    form.addEventListener('submit', function (e) {

        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token')
            },
            body: formData
        }).then(function () {
            ratingModal.hide();
        });
    });
});