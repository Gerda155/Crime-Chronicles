document.querySelectorAll('.rating-stars .star').forEach(star => {
    star.addEventListener('click', function () {
        let value = this.dataset.value;
        let parent = this.parentElement;

        parent.querySelectorAll('.star').forEach(s => {
            s.style.color = '#555';
        });

        for (let i = 0; i < value; i++) {
            parent.querySelectorAll('.star')[i].style.color = '#ffc107';
        }
    });
});