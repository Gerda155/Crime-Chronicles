<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Pilnais vārds</label>

            <input
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control rounded bg-dark text-light border-secondary @error('name') is-invalid @enderror"
                required>

            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Lietotājvārds</label>

            <input
                name="username"
                value="{{ old('username', $user->username) }}"
                class="form-control rounded bg-dark text-light border-secondary @error('username') is-invalid @enderror"
                required>

            @error('username')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">E-pasts</label>

            <input
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control rounded bg-dark text-light border-secondary @error('email') is-invalid @enderror"
                required>

            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">Par mani</label>

            <textarea
                name="bio"
                rows="3"
                maxlength="300"
                class="form-control rounded bg-dark text-light border-secondary @error('bio') is-invalid @enderror">{{ old('bio', $user->bio) }}</textarea>

            @error('bio')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">Avatars</label>

            <input
                type="file"
                id="avatarInput"
                accept="image/*"
                class="form-control bg-dark text-light border-secondary @error('avatar_cropped') is-invalid @enderror">

            @error('avatar_cropped')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <div id="avatarPreviewWrapper"
                class="mt-3 w-64 h-64 border border-secondary overflow-hidden d-none rounded">

                <img id="avatarPreview" class="w-100 h-100 object-fit-cover">
            </div>

            <input type="hidden" name="avatar_cropped" id="avatarCropped">
        </div>

        <div class="col-md-6">
            <label class="form-label">Jauna parole</label>

            <input
                type="password"
                name="password"
                class="form-control rounded bg-dark text-light border-secondary @error('password') is-invalid @enderror">

            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Apstiprināt paroli</label>

            <input
                type="password"
                name="password_confirmation"
                class="form-control rounded bg-dark text-light border-secondary">
        </div>
    </div>

    <button class=" btn btn-success mt-4">Saglabāt izmaiņas</button>
</form>