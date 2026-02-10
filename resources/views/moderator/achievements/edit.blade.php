<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rediģēt sasniegumu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <h1 class="text-center mb-4 fw-bold text-pink">Rediģēt sasniegumu</h1>

        <form
            action="{{ route('moderator.achievements.update', $achievement->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-secondary p-4 rounded shadow-sm">

            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nosaukums</label>
                <input type="text" name="title" class="form-control" value="{{ $achievement->title }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apraksts</label>
                <textarea name="description" class="form-control" required>{{ $achievement->description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ikona</label>

                <div class="mb-2">
                    <img
                        id="iconPreview"
                        src="{{ $achievement->icon
                        ? asset('storage/'.$achievement->icon)
                        : asset('storage/achievements/default.png') }}"
                        width="160"
                        height="160"
                        style="object-fit: contain;">
                </div>

                <input
                    type="file"
                    name="icon"
                    class="form-control"
                    onchange="previewIcon(event)">
            </div>

            <button type="submit" class="btn btn-success rounded">Atjaunināt</button>
            <a href="{{ route('moderator.achievements.index') }}" class="btn btn-secondary rounded">Atpakaļ</a>
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