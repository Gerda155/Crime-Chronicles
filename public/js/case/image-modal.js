document.addEventListener('DOMContentLoaded', function () {

    const wrappers = document.querySelectorAll('.evidence-img-wrapper');

    const imageModalEl = document.getElementById('imageModal');

    if (!imageModalEl) return;

    const imageModal = new bootstrap.Modal(imageModalEl);

    const modalImg = document.getElementById('modalImage');

    let currentKeyArea = null;

    let currentWrapper = null;

    wrappers.forEach(function (wrapper) {

        const img = wrapper.querySelector('.evidence-img');

        wrapper.addEventListener('click', function () {

            modalImg.src = img.src;

            currentWrapper = wrapper;

            try {

                currentKeyArea = JSON.parse(img.dataset.keyArea);

            } catch {

                currentKeyArea = null;
            }

            imageModal.show();
        });
    });

    modalImg.addEventListener('click', function (e) {

        if (!currentKeyArea || !currentWrapper) return;

        const rect = modalImg.getBoundingClientRect();

        const clickX = e.clientX - rect.left;

        const clickY = e.clientY - rect.top;

        const scaleX = modalImg.clientWidth / modalImg.naturalWidth;
        const scaleY = modalImg.clientHeight / modalImg.naturalHeight;

        const x = currentKeyArea.x * scaleX;
        const y = currentKeyArea.y * scaleY;
        const w = currentKeyArea.width * scaleX;
        const h = currentKeyArea.height * scaleY;

        const inside =
            clickX >= x &&
            clickX <= x + w &&
            clickY >= y &&
            clickY <= y + h;

        if (!inside) return;

        if (currentWrapper.dataset.found) {

            showSmallNotification(
                'Jūs jau atradāt šo pierādījumu!',
                'warning'
            );

            return;
        }

        currentWrapper.dataset.found = 'true';

        let opened =
            parseInt(document.getElementById('openedEvidenceCount').value) || 0;

        opened++;

        document.getElementById('openedEvidenceCount').value = opened;

        addScore(20);

        updateProgress(opened);

        TutorialSystem.trigger('hidden_object');

        showSmallNotification(
            'Pierādījums atrasts! +20 punkti',
            'success'
        );

        setTimeout(function () {
            imageModal.hide();
        }, 1500);
    });
});