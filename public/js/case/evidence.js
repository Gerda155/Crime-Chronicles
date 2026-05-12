document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.reveal-btn');

    const submitBtn = document.getElementById('submitBtn');

    const openedInput = document.getElementById('openedEvidenceCount');

    let score = 0;

    window.addScore = function (points) {

        score += points;

        const scoreInput = document.getElementById('scoreInput');

        const scoreDisplay = document.getElementById('scoreDisplay');

        if (scoreInput) {
            scoreInput.value = score;
        }

        if (scoreDisplay) {
            scoreDisplay.innerText = 'Punkti: ' + score;
        }
    };

    buttons.forEach(function (btn) {

        btn.addEventListener('click', function () {

            TutorialSystem.trigger('evidence_click');

            const content = btn.nextElementSibling;

            const isHidden = content.classList.contains('d-none');

            if (isHidden) {

                content.classList.remove('d-none');

                btn.textContent = 'Paslēpt';

                if (!content.dataset.counted) {

                    content.dataset.counted = 'true';

                    addScore(15);

                    let opened =
                        parseInt(openedInput.value) || 0;

                    opened++;

                    openedInput.value = opened;

                    updateProgress(opened);

                    if (opened >= 2) {

                        TutorialSystem.trigger('evidence_count_2');

                        document.querySelectorAll('.locked-question')
                            .forEach(q => q.classList.remove('d-none'));

                        document.querySelectorAll('.question-buttons')
                            .forEach(q => q.style.display = 'flex');

                        document.querySelectorAll('.question-message')
                            .forEach(m => m.classList.add('d-none'));

                        document.querySelectorAll('.msg')
                            .forEach(m => m.classList.remove('d-none'));
                    }

                    if (submitBtn) {
                        submitBtn.disabled = opened < 2;
                    }

                    showSmallNotification(
                        'Pierādījums atvērts! +15 punkti',
                        'success'
                    );
                }

            } else {

                content.classList.add('d-none');

                btn.textContent = 'Atvērt pierādījumu';
            }
        });
    });
});