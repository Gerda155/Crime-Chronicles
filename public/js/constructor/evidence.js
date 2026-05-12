document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('fileInput');
    const previewImg = document.getElementById('previewImage');
    const selectionBox = document.getElementById('selectionBox');
    const hiddenArea = document.getElementById('key_object_area');
    const imageBlock = document.getElementById('imageBlock');
    const nextBtn = document.getElementById('nextBtn');
    const evidenceCountSpan = document.getElementById('evidenceCount');

    let evidenceCount = window.evidenceData?.evidenceCount || 0;

    let startX = 0;
    let startY = 0;
    let isDrawing = false;
    let imgRect = null;

    function resetSelection() {
        if (selectionBox) {
            selectionBox.classList.remove('visible');
            selectionBox.style.left = '0px';
            selectionBox.style.top = '0px';
            selectionBox.style.width = '0px';
            selectionBox.style.height = '0px';
        }

        if (hiddenArea) {
            hiddenArea.value = '';
        }

        isDrawing = false;
    }

    if (fileInput) {
        fileInput.addEventListener('change', function (e) {

            const file = e.target.files[0];

            if (!file) {
                imageBlock?.classList.add('d-none');

                if (previewImg) {
                    previewImg.style.display = 'none';
                }

                resetSelection();
                return;
            }

            if (file.type.startsWith('image/')) {

                imageBlock?.classList.remove('d-none');

                const reader = new FileReader();

                reader.onload = function (event) {

                    if (previewImg) {
                        previewImg.src = event.target.result;
                        previewImg.style.display = 'block';
                    }

                    resetSelection();
                };

                reader.readAsDataURL(file);

            } else {

                imageBlock?.classList.add('d-none');

                if (previewImg) {
                    previewImg.style.display = 'none';
                }

                resetSelection();
            }
        });
    }

    if (previewImg) {

        previewImg.addEventListener('mousedown', function (e) {

            if (previewImg.style.display === 'none') return;

            imgRect = previewImg.getBoundingClientRect();

            startX = (e.clientX - imgRect.left) / imgRect.width;
            startY = (e.clientY - imgRect.top) / imgRect.height;

            startX = Math.min(1, Math.max(0, startX));
            startY = Math.min(1, Math.max(0, startY));

            isDrawing = true;

            if (selectionBox) {
                selectionBox.classList.add('visible');

                selectionBox.style.left = (startX * 100) + '%';
                selectionBox.style.top = (startY * 100) + '%';
                selectionBox.style.width = '0%';
                selectionBox.style.height = '0%';
            }

            e.preventDefault();
        });

        previewImg.addEventListener('mousemove', function (e) {

            if (!isDrawing) return;

            imgRect = previewImg.getBoundingClientRect();

            let currentX = (e.clientX - imgRect.left) / imgRect.width;
            let currentY = (e.clientY - imgRect.top) / imgRect.height;

            currentX = Math.min(1, Math.max(0, currentX));
            currentY = Math.min(1, Math.max(0, currentY));

            const left = Math.min(startX, currentX);
            const top = Math.min(startY, currentY);

            const width = Math.abs(currentX - startX);
            const height = Math.abs(currentY - startY);

            if (selectionBox) {
                selectionBox.style.left = (left * 100) + '%';
                selectionBox.style.top = (top * 100) + '%';
                selectionBox.style.width = (width * 100) + '%';
                selectionBox.style.height = (height * 100) + '%';
            }
        });

        previewImg.addEventListener('mouseup', function (e) {

            if (!isDrawing) return;

            imgRect = previewImg.getBoundingClientRect();

            let endX = (e.clientX - imgRect.left) / imgRect.width;
            let endY = (e.clientY - imgRect.top) / imgRect.height;

            endX = Math.min(1, Math.max(0, endX));
            endY = Math.min(1, Math.max(0, endY));

            let finalLeft = Math.min(startX, endX);
            let finalTop = Math.min(startY, endY);

            let finalWidth = Math.abs(endX - startX);
            let finalHeight = Math.abs(endY - startY);

            if (finalWidth < 0.05 && finalHeight < 0.05) {

                finalLeft = Math.max(0, startX - 0.05);
                finalTop = Math.max(0, startY - 0.05);

                finalWidth = 0.1;
                finalHeight = 0.1;

                if (finalLeft + finalWidth > 1) {
                    finalLeft = 1 - finalWidth;
                }

                if (finalTop + finalHeight > 1) {
                    finalTop = 1 - finalHeight;
                }

                if (selectionBox) {
                    selectionBox.style.left = (finalLeft * 100) + '%';
                    selectionBox.style.top = (finalTop * 100) + '%';
                    selectionBox.style.width = (finalWidth * 100) + '%';
                    selectionBox.style.height = (finalHeight * 100) + '%';
                }
            }

            const areaData = {
                x: finalLeft,
                y: finalTop,
                width: finalWidth,
                height: finalHeight
            };

            if (hiddenArea) {
                hiddenArea.value = JSON.stringify(areaData);
            }

            isDrawing = false;
        });

        previewImg.addEventListener('mouseleave', function () {

            if (isDrawing) {

                isDrawing = false;

                if (hiddenArea && hiddenArea.value === '') {
                    selectionBox?.classList.remove('visible');
                }
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {

            if (evidenceCount < 2) {
                e.preventDefault();
                alert('Nepieciešams pievienot vismaz 2 pierādījumus!');
            }
        });
    }
});