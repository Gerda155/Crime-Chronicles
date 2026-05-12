document.addEventListener('DOMContentLoaded', function () {

    const askedQuestions = new Set();

    document.querySelectorAll('.ask-btn').forEach(function (btn) {

        btn.addEventListener('click', function () {

            TutorialSystem.trigger('ask_question');

            const allAnswers = btn.closest('.questions')
                .querySelectorAll('.answer');

            allAnswers.forEach(function (a) {
                a.classList.add('d-none');
            });

            const answer = btn.nextElementSibling;

            answer.classList.remove('d-none');

            const questionText = btn.textContent.trim();

            if (!askedQuestions.has(questionText)) {

                askedQuestions.add(questionText);

                const opened =
                    parseInt(document.getElementById('openedEvidenceCount').value) || 0;

                addScore(10);

                updateProgress(opened, askedQuestions.size);

                showSmallNotification(
                    'Jautājums uzdots! +10 punkti',
                    'success'
                );
            }
        });
    });
});