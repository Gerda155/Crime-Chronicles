document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.suspect-slide');
    let current = 0;
    
    if (slides.length > 0) {
        function showSlide(index) {
            slides.forEach(function (s, i) {
                s.classList.toggle('d-none', i !== index);
            });
        }
        
        const prevBtn = document.getElementById('prevSuspect');
        const nextBtn = document.getElementById('nextSuspect');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);

                document.querySelectorAll('.questions').forEach(q => {
                    q.classList.add('d-none');
                });
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                current = (current + 1) % slides.length;
                showSlide(current);

                document.querySelectorAll('.questions').forEach(q => {
                    q.classList.add('d-none');
                });
            });
        }
    }

    const suspectCards = document.querySelectorAll('.suspect-card');
    const selectedSuspectId = document.getElementById('selectedSuspectId');
    const submitBtn = document.getElementById('submitBtn');
    const openedEvidenceCount = document.getElementById('openedEvidenceCount');
    
    function updateSubmitButton() {
        if (!submitBtn) return;
        
        const openedCount = parseInt(openedEvidenceCount?.value || 0);
        const hasSelectedSuspect = selectedSuspectId && selectedSuspectId.value;
        
        submitBtn.disabled = !(openedCount >= 2 && hasSelectedSuspect);
    }
    
    suspectCards.forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON' || e.target.closest('.ask-btn')) {
                return;
            }
            
            const suspectId = this.dataset.suspectId;
            const suspectName = this.dataset.suspectName;
            const questionsBlock = this.querySelector('.questions');
            
            suspectCards.forEach(function(c) {
                c.classList.remove('border-primary', 'selected-suspect');
                c.style.border = '';

                const otherQuestions = c.querySelector('.questions');
                if (otherQuestions) {
                    otherQuestions.classList.add('d-none');
                }
            });
            
            this.classList.add('border-primary', 'selected-suspect');
            this.style.border = '3px solid #0d6efd';

            if (selectedSuspectId) {
                selectedSuspectId.value = suspectId;
            }

            const openedCount = parseInt(openedEvidenceCount?.value || 0);
            
            if (questionsBlock) {
                if (openedCount >= 2) {
                    questionsBlock.classList.remove('d-none');

                    if (typeof showSmallNotification === 'function') {
                        showSmallNotification(`Sākat pratināšanu: ${suspectName}`, 'info');
                    }
                } else {
                    questionsBlock.classList.remove('d-none');
                    const msgElement = questionsBlock.querySelector('.question-message');
                    if (msgElement) {
                        msgElement.style.display = 'block';
                    }
                    
                    if (typeof showSmallNotification === 'function') {
                        showSmallNotification(`Nepieciešams atvērt vismaz 2 pierādījumus, lai pratinātu ${suspectName}`, 'warning');
                    }
                }
            }

            updateSubmitButton();
        });
    });
    
    if (openedEvidenceCount) {
        const observer = new MutationObserver(updateSubmitButton);
        observer.observe(openedEvidenceCount, { attributes: true, attributeFilter: ['value'] });
    }
    
    updateSubmitButton();
});