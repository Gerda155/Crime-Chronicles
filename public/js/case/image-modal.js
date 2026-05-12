document.addEventListener('DOMContentLoaded', function () {

    const wrappers = document.querySelectorAll('.evidence-img-wrapper');
    const imageModalEl = document.getElementById('imageModal');

    if (!imageModalEl) return;

    const imageModal = new bootstrap.Modal(imageModalEl);
    const modalImg = document.getElementById('modalImage');

    let currentKeyArea = null;
    let currentWrapper = null;
    let currentImg = null;

    wrappers.forEach(function (wrapper) {
        const img = wrapper.querySelector('.evidence-img');
        if (!img) return;

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('selection-box')) return;
            
            modalImg.src = img.src;
            currentWrapper = wrapper;
            currentImg = img;

            try {
                if (img.dataset.keyArea && img.dataset.keyArea !== 'null' && img.dataset.keyArea !== '') {
                    let parsed = JSON.parse(img.dataset.keyArea);
                    
                    if (typeof parsed === 'string') {
                        parsed = JSON.parse(parsed);
                    }
                    
                    currentKeyArea = parsed;
                } else {
                    currentKeyArea = null;
                }
            } catch (e) {
                currentKeyArea = null;
            }

            imageModal.show();
        });
    });

    modalImg.addEventListener('click', function (e) {
        if (!currentKeyArea || !currentWrapper) {
            return;
        }

        if (currentWrapper.dataset.keyAreaFound === 'true') {
            showSmallNotification('Jūs jau atradāt šo pierādījumu!', 'warning');
            return;
        }

        const rect = modalImg.getBoundingClientRect();

        const clickX = e.clientX - rect.left;
        const clickY = e.clientY - rect.top;

        const imgDisplayWidth = rect.width;
        const imgDisplayHeight = rect.height;

        const relativeClickX = clickX / imgDisplayWidth;
        const relativeClickY = clickY / imgDisplayHeight;

        const targetX = currentKeyArea.x;
        const targetY = currentKeyArea.y;
        const targetWidth = currentKeyArea.width;
        const targetHeight = currentKeyArea.height;
        
        const inside = relativeClickX >= targetX &&
                      relativeClickX <= targetX + targetWidth &&
                      relativeClickY >= targetY &&
                      relativeClickY <= targetY + targetHeight;
        
        if (!inside) {
            showSmallNotification('Nepareiza vieta! Turpini meklēt...', 'error');
            return;
        }

        currentWrapper.dataset.keyAreaFound = 'true';

        const originalWrapper = currentWrapper;
        if (originalWrapper) {

            const oldOverlay = originalWrapper.querySelector('.found-overlay');
            if (oldOverlay) oldOverlay.remove();

            const overlay = document.createElement('div');
            overlay.className = 'found-overlay';

            const parentRect = originalWrapper.getBoundingClientRect();
            const imgRect = originalWrapper.querySelector('img').getBoundingClientRect();

            const offsetX = imgRect.left - parentRect.left;
            const offsetY = imgRect.top - parentRect.top;
            
            overlay.style.position = 'absolute';
            overlay.style.left = (offsetX + (currentKeyArea.x * imgRect.width)) + 'px';
            overlay.style.top = (offsetY + (currentKeyArea.y * imgRect.height)) + 'px';
            overlay.style.width = (currentKeyArea.width * imgRect.width) + 'px';
            overlay.style.height = (currentKeyArea.height * imgRect.height) + 'px';
            overlay.style.border = '3px solid #00ff00';
            overlay.style.backgroundColor = 'rgba(0, 255, 0, 0.2)';
            overlay.style.borderRadius = '4px';
            overlay.style.pointerEvents = 'none';
            overlay.style.zIndex = '10';
            
            originalWrapper.style.position = 'relative';
            originalWrapper.appendChild(overlay);
        }

        if (typeof window.addScore === 'function') {
            window.addScore(20);
        }

        let opened = parseInt(document.getElementById('openedEvidenceCount')?.value || 0);
        if (typeof updateProgress === 'function') {
            updateProgress(opened, 0);
        }

        if (typeof TutorialSystem !== 'undefined' && TutorialSystem.trigger) {
            TutorialSystem.trigger('hidden_object');
        }

        showSmallNotification('Atrasts slepenais pierādījums! +20 punkti', 'success');

        setTimeout(function () {
            imageModal.hide();
        }, 1500);
    });
});