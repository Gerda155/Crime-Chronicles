<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izveidot lietu</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">Izveidot jaunu lietu</h1>

        <form
            action="{{ route('moderator.cases.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-secondary p-4 rounded shadow-sm">

            @csrf

            <div class="mb-3">
                <label class="form-label">Nosaukums</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Apraksts</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Žanrs</label>
                <select class="form-select" name="genre_id">
                    <option value="">Izvēlies žanru</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Vērtējums</label>
                <input type="number" name="rating" class="form-control" value="{{ old('rating') }}" min="0" max="5" step="0.1">
            </div>

            <div class="mb-2">
                <img id="iconPreview" src="{{ asset('storage/cases/default.png') }}" width="160" height="160" style="object-fit: contain;">
            </div>
            <input type="file" name="image" class="form-control" onchange="previewIcon(event)">

            <button type="submit" class="btn btn-success rounded">Saglabāt</button>
            <a href="{{ route('moderator.cases.index') }}" class="btn btn-secondary rounded">Atpakaļ</a>
        </form>
    </main>

    @include('partials.footer')

    <script>
        function previewIcon(event) {
            const img = document.getElementById('iconPreview');
            img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</body>
</html>
