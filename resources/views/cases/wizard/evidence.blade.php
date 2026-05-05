<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <title>Crime Chronicles - Pierādījumi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .image-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }

        #previewImage {
            max-width: 100%;
            cursor: crosshair;
            border-radius: 8px;
            display: block;
        }

        .selection-box {
            position: absolute;
            border: 2px solid #ff4da6;
            background: rgba(255, 77, 166, 0.2);
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold text-pink">
            Pierādījumi
        </h1>

        <div class="text-center mb-3 text-secondary">
            Lieta: <strong class="text-light">{{ $case->title }}</strong>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- LIST --}}
                <div class="card bg-secondary text-light border-0 mb-4">
                    <div class="card-body">

                        <h5>Pievienotie pierādījumi</h5>

                        @forelse($evidence as $item)
                        <div class="border-bottom py-3">

                            @if($item->image_path && Str::endsWith($item->image_path, ['pdf']))
                            <a href="{{ asset($item->image_path) }}" target="_blank">
                                📄 Atvērt dokumentu
                            </a>

                            @elseif($item->image_path && Str::endsWith($item->image_path, ['doc','docx']))
                            <a href="{{ asset($item->image_path) }}" target="_blank">
                                📄 Atvērt dokumentu
                            </a>

                            @elseif($item->image_path)
                            <img src="{{ asset($item->image_path) }}"
                                class="img-fluid rounded mb-2">
                            @endif

                            <div>
                                <strong>{{ $item->description }}</strong>
                            </div>

                            @if($item->key_object_area)
                            <small class="text-info d-block mt-1">
                                Zona: {{ json_encode($item->key_object_area) }}
                            </small>
                            @endif

                        </div>
                        @empty
                        <p class="text-muted">Nav pierādījumu</p>
                        @endforelse

                    </div>
                </div>

                {{-- FORM --}}
                <div class="card bg-secondary text-light border-0">
                    <div class="card-body">

                        <form method="POST"
                            action="{{ route('cases.evidence.store', $case->id) }}"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Apraksts</label>
                                <textarea name="description"
                                    class="form-control bg-dark text-light border-0"
                                    required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fails</label>
                                <input type="file"
                                    id="imageInput"
                                    name="file"
                                    class="form-control bg-dark text-light border-0">
                            </div>

                            {{-- IMAGE + SELECTION --}}
                            <div class="mb-3">
                                <label class="form-label">Atzīmē objektu (ja ir attēls)</label>

                                <div class="image-wrapper">
                                    <img id="previewImage">

                                    <div id="selectionBox" class="selection-box d-none"></div>
                                </div>
                            </div>

                            <input type="hidden" name="key_object_area" id="key_object_area">

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('cases.suspects', $case->id) }}"
                                    class="btn btn-outline-light">
                                    Atpakaļ
                                </a>

                                <button class="btn btn-primary">
                                    Pievienot
                                </button>

                            </div>

                        </form>

                    </div>
                </div>

                {{-- NEXT --}}
                <div class="text-end mt-4">
                    <a href="/cases/{{ $case->id }}/questions"
                        class="btn btn-success">
                        Tālāk →
                    </a>
                </div>

            </div>
        </div>

    </main>

    <script>
        const input = document.getElementById('imageInput');
        const img = document.getElementById('previewImage');
        const box = document.getElementById('selectionBox');
        const hidden = document.getElementById('key_object_area');

        let startX, startY;
        let isSelecting = false;

        // загрузка изображения
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });

        // старт выделения
        img.addEventListener('mousedown', function(e) {
            const rect = img.getBoundingClientRect();

            startX = (e.clientX - rect.left) / rect.width;
            startY = (e.clientY - rect.top) / rect.height;

            isSelecting = true;

            box.classList.remove('d-none');
        });

        // движение мыши
        img.addEventListener('mousemove', function(e) {
            if (!isSelecting) return;

            const rect = img.getBoundingClientRect();

            const x = (e.clientX - rect.left) / rect.width;
            const y = (e.clientY - rect.top) / rect.height;

            const left = Math.min(startX, x);
            const top = Math.min(startY, y);
            const width = Math.abs(x - startX);
            const height = Math.abs(y - startY);

            box.style.left = (left * 100) + '%';
            box.style.top = (top * 100) + '%';
            box.style.width = (width * 100) + '%';
            box.style.height = (height * 100) + '%';
        });

        // завершение
        img.addEventListener('mouseup', function(e) {
            if (!isSelecting) return;

            const rect = img.getBoundingClientRect();

            const endX = (e.clientX - rect.left) / rect.width;
            const endY = (e.clientY - rect.top) / rect.height;

            const data = {
                x: Math.min(startX, endX),
                y: Math.min(startY, endY),
                width: Math.abs(endX - startX),
                height: Math.abs(endY - startY)
            };

            hidden.value = JSON.stringify(data);

            isSelecting = false;
        });
    </script>

</body>

</html>