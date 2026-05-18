document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarPreviewWrapper = document.getElementById('avatarPreviewWrapper');
    const avatarCropped = document.getElementById('avatarCropped');
    let cropper;

    avatarInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function () {
            avatarPreview.src = reader.result;
            avatarPreviewWrapper.classList.remove('d-none');

            if (cropper) cropper.destroy();
            cropper = new Cropper(avatarPreview, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                movable: true,
                zoomable: true,
                rotatable: false,
                scalable: false,
            });
        };
        reader.readAsDataURL(file);
    });

    const profileForm = avatarInput.closest('form');
    profileForm.addEventListener('submit', function (e) {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 250,
                height: 250
            });
            avatarCropped.value = canvas.toDataURL('image/jpeg');
        }
    });
});