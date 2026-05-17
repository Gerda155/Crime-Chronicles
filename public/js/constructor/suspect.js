document.addEventListener('DOMContentLoaded', function () {

    const cards = document.querySelectorAll('.suspect-card');
    const nextBtn = document.getElementById('nextBtn');
    const selectedName = document.getElementById('selectedName');
    const fileInput = document.getElementById('imageInput');

    const suspectsCount = window.suspectData.suspectsCount;
    let currentAnswerId = window.suspectData.currentAnswerId;
    const setAnswerUrl = window.suspectData.setAnswerUrl;
    const csrfToken = window.suspectData.csrfToken;

    cards.forEach(function (card) {

        const suspectId = card.dataset.id;

        if (suspectId == currentAnswerId) {
            card.classList.add('selected');
        }
    });

    function saveGuilty(suspectId, suspectName) {

        fetch(setAnswerUrl, {
            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },

            body: JSON.stringify({
                answer_id: suspectId
            })
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {

                if (data.success) {

                    currentAnswerId = suspectId;

                    selectedName.textContent = suspectName;

                    if (suspectsCount >= 2 && currentAnswerId) {
                        nextBtn.classList.remove('disabled');
                        nextBtn.removeAttribute('disabled');
                    }

                }
            })
            .catch(function (error) {

                console.error(error);

            });
    }

    cards.forEach(function (card) {

        card.addEventListener('click', function (e) {

            if (
                e.target.tagName === 'BUTTON' ||
                e.target.tagName === 'INPUT' ||
                e.target.tagName === 'A'
            ) {
                return;
            }

            const suspectId = this.dataset.id;
            const suspectName = this.dataset.name;

            cards.forEach(function (c) {
                c.classList.remove('selected');
            });

            this.classList.add('selected');

            saveGuilty(suspectId, suspectName);
        });
    });

    function updateNextButton() {

        if (
            suspectsCount >= 2 &&
            currentAnswerId
        ) {

            nextBtn.classList.remove('disabled');
            nextBtn.removeAttribute('disabled');

        } else {

            nextBtn.classList.add('disabled');
            nextBtn.setAttribute('disabled', 'disabled');
        }
    }

    updateNextButton();

    if (fileInput) {

        fileInput.addEventListener('change', function () {

            const fileName =
                this.files[0]?.name ||
                'Nav izvēlēts fails';

            const label =
                this.parentElement.querySelector('.file-name');

            if (label) {
                label.textContent = fileName;
            }

            if (this.files.length > 0) {
                this.parentElement.classList.add('has-file');
            } else {
                this.parentElement.classList.remove('has-file');
            }
        });
    }

    if (window.suspectData.currentAnswerName) {
        selectedName.textContent = window.suspectData.currentAnswerName;
    }
});