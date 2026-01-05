<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body>
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <div class="row g-4">

            {{-- Profile --}}
            <div class="col-lg-4">
                <div class="card bg-dark text-light shadow-lg border-0">
                    <div class="card-body d-flex flex-column align-items-center text-center">

                        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/avatar-placeholder.jpg') }}"
                            class="rounded-circle mb-3 border border-secondary"
                            width="250" height="250"
                            style="object-fit: cover;">

                        <h4 class="mb-0">{{ $user->username }}</h4>

                        <hr class="border-secondary">

                        <p class="small">
                            {{ $user->bio ?: 'Nav apraksta' }}
                        </p>

                        <h6 class="text-uppercase card-text mt-4 mb-3">Sasniegumi</h6>

                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            @forelse($user->achievements as $ach)
                            <div class="card bg-secondary text-dark text-center p-2" style="width: 120px;">
                                <img src="{{ $ach->icon 
                        ? asset('images/achievements/'.$ach->icon) 
                        : asset('images/achievements/default.png') }}"
                                    class="mb-2 mx-auto"
                                    style="width: 50px; height: 50px; object-fit: contain;">
                                <div class="small fw-bold">{{ $ach->title }}</div>
                            </div>
                            @empty
                            <div class="text-secondary">Nav sasniegumu</div>
                            @endforelse
                        </div>

                        <small class="text-secondary mb-2"> Detektīvs kopš: {{ $user->created_at->format('d.m.Y') }}</small>
                    </div>
                </div>
            </div>

            {{-- REDIĢĒŠANA --}}
            <div class="col-lg-8">
                <div class="card bg-dark text-light shadow-lg border-0">
                    <div class="card-body">
                        <h5 class="mb-4">Profila iestatījumi</h5>
                        @error('field')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Pilnais vārds</label>
                                    <input name="name" class="form-control rounded @error('field') is-invalid @enderror" value="{{ $user->name }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Lietotājvārds</label>
                                    <input name="username" class="form-control rounded @error('field') is-invalid @enderror"
                                        value="{{ $user->username }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">E-pasts</label>
                                    <input name="email" type="email" class="form-control rounded @error('field') is-invalid @enderror"
                                        value="{{ $user->email }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Par mani</label>
                                    <textarea name="bio" class="form-control rounded @error('field') is-invalid @enderror" maxlength="300"
                                        rows="3">{{ $user->bio }}</textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Avatars</label>
                                    <input type="file" id="avatarInput" accept="image/*" class="form-control @error('avatar') is-invalid @enderror">
                                    @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div id="avatarPreviewWrapper" class="mt-3 w-64 h-64 border border-secondary overflow-hidden d-none">
                                        <img id="avatarPreview" class="w-100 h-100 object-cover">
                                    </div>

                                    <input type="hidden" name="avatar_cropped" id="avatarCropped">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jauna parole</label>
                                    <input type="password" name="password" class="form-control rounded @error('field') is-invalid @enderror"">
                                </div>

                                <div class=" col-md-6">
                                    <label class="form-label">Apstiprināt paroli</label>
                                    <input type="password" name="password_confirmation" class="form-control rounded @error('field') is-invalid @enderror"">
                                </div>
                            </div>

                            <button class=" btn btn-success mt-4">
                                    Saglabāt izmaiņas
                                    </button>
                        </form>
                    </div>
                </div>

                {{-- DZĒŠANA --}}
                <div class="card bg-danger bg-opacity-10 border border-danger mt-4">
                    <div class="card-body">
                        <h6 class="text-danger">Bīstama zona</h6>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <input type="password" name="password"
                                class="form-control mb-3"
                                placeholder="Ievadi paroli apstiprināšanai" required>

                            <button class="btn btn-danger w-100">
                                Dzēst profilu
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatarInput');
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarPreviewWrapper = document.getElementById('avatarPreviewWrapper');
            const avatarCropped = document.getElementById('avatarCropped');
            let cropper;

            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function() {
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
            profileForm.addEventListener('submit', function(e) {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 250,
                        height: 250
                    });
                    avatarCropped.value = canvas.toDataURL('image/jpeg');
                }
            });
        });
    </script>

    @include('partials.footer')

</body>

</html>