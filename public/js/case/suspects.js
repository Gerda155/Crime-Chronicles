document.addEventListener('DOMContentLoaded', function () {

    const slides = document.querySelectorAll('.suspect-slide');

    let current = 0;

    function showSlide(index) {

        slides.forEach(function (s, i) {
            s.classList.toggle('d-none', i !== index);
        });
    }

    const prevBtn = document.getElementById('prevSuspect');
    const nextBtn = document.getElementById('nextSuspect');

    prevBtn?.addEventListener('click', function () {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    });

    nextBtn?.addEventListener('click', function () {
        current = (current + 1) % slides.length;
        showSlide(current);
    });
});