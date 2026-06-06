document.addEventListener('DOMContentLoaded', function() {
    console.log('Setting up evidence handlers...');
    
    const buttons = document.querySelectorAll('.reveal-btn');
    const submitBtn = document.getElementById('submitBtn');
    const openedInput = document.getElementById('openedEvidenceCount');
    let score = 0;
    let evidenceOpenedCount = parseInt(openedInput?.value) || 0;

    window.addScore = function(points) {
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

    function updateEvidenceCount() {
        if (openedInput) {
            evidenceOpenedCount = parseInt(openedInput.value) || 0;
        }
        
        if (submitBtn) {
            const selectedSuspect = document.getElementById('selectedSuspectId')?.value;
            submitBtn.disabled = !(evidenceOpenedCount >= 2 && selectedSuspect);
        }
    }

    buttons.forEach(function(btn) {
        btn.removeEventListener('click', btn._listener);
        
        const handler = function(e) {
            e.preventDefault();
            console.log('Evidence button clicked');
            
            const content = btn.nextElementSibling;
            const isHidden = content.classList.contains('d-none');

            if (isHidden) {
                content.classList.remove('d-none');
                btn.textContent = 'Paslēpt';

                if (!content.dataset.counted) {
                    content.dataset.counted = 'true';
                    
                    if (typeof addScore === 'function') {
                        addScore(15);
                    }

                    evidenceOpenedCount++;
                    if (openedInput) {
                        openedInput.value = evidenceOpenedCount;
                    }

                    if (typeof TutorialSystem !== 'undefined' && TutorialSystem.markEvidenceOpened) {
                        TutorialSystem.markEvidenceOpened(btn);
                    }

                    if (typeof showSmallNotification === 'function') {
                        showSmallNotification('Pierādījums atvērts! +15 punkti', 'success');
                    }

                    if (evidenceOpenedCount >= 2) {
                        document.querySelectorAll('.locked-question').forEach(q => {
                            q.classList.remove('d-none');
                        });
                        document.querySelectorAll('.question-buttons').forEach(q => {
                            q.style.display = 'flex';
                        });
                        document.querySelectorAll('.question-message').forEach(m => {
                            m.classList.add('d-none');
                        });
                    }

                    updateEvidenceCount();
                }
            } else {
                content.classList.add('d-none');
                btn.textContent = 'Atvērt pierādījumu';
            }
        };
        
        btn._listener = handler;
        btn.addEventListener('click', handler);
    });

    updateEvidenceCount();
});