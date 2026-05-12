<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Pierādījumi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            Lietas: <strong class="text-light">"{{ $case->title }}"</strong> pierādījumi
        </h1>

        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>3. solis no 4</span>
                <span>Pieradījumi</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 60%;"></div>
            </div>
        </div>

        <div class="alert alert-dark border-0 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="display-6"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div>
                    <strong>Detektīv, ir pienācis laiks vākt pierādījumus!</strong><br>
                    Katrai lietai ir vajadzīgi <strong>pierādījumi</strong>, kas palīdzēs atklāt patiesību.
                    Pievieno vismaz <strong>2 pierādījumus</strong> - tie var būt attēli, teksts, PDF vai dokumenti.<br>
                    Ja pievieno attēlu, vari <strong>iezīmēt svarīgāko vietu</strong> ar peli - spēlētājs to noteikti pamanīs!<br>
                    <small class="text-secondary"><i class="fa-solid fa-lightbulb" style="color: #dabe69;"></i> Padoms: Jo interesantāki un noslēpumaināki pierādījumi, jo aizraujošāka būs spēle!</small>
                    <div class="mt-2">
                        <small> Pašlaik pievienoti: <span id="evidenceCount">{{ count($evidence) }}</span></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3"><i class="fa-solid fa-list"></i> Pievienotie pierādījumi</h5>

                @forelse($evidence as $item)
                <div class="suspect-card w-100 mb-3 p-3 rounded d-flex gap-3 align-items-start"
                    data-id="{{ $item->id }}">

                    <div style="width:80px; flex-shrink:0;">
                        @if($item->image_path && Str::endsWith($item->image_path, ['pdf']))
                        <div class="text-center" style="font-size: 2rem;"><i class="fa-solid fa-file-pdf"></i></div>
                        @elseif($item->image_path && Str::endsWith($item->image_path, ['doc','docx']))
                        <div class="text-center" style="font-size: 2rem;"><i class="fa-solid fa-file-word"></i></div>
                        @elseif($item->image_path)
                        <img src="{{ asset($item->image_path) }}"
                            class="rounded"
                            style="width:80px; height:80px; object-fit:cover;">
                        @else
                        <div class="text-center" style="font-size: 2rem;"><i class="fa-solid fa-file-alt"></i></div>
                        @endif
                    </div>

                    <div class="flex-grow-1">
                        <strong><i class="fa-solid fa-tag"></i> {{ $item->description }}</strong>
                        @if($item->image_path)
                        <div class="mt-1">
                            <a href="{{ asset($item->image_path) }}" target="_blank" class="text-info">
                                <i class="fa-solid fa-external-link"></i> Atvērt failu
                            </a>
                        </div>
                        @endif
                        @if($item->key_object_area)
                        <small class="text-dark d-block mt-1">
                            <i class="fa-solid fa-magnifying-glass"></i> Ir atzīmēta svarīga zona
                        </small>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3"><i class="fa-solid fa-folder-open"></i> Nav pievienotu pierādījumu</p>
                @endforelse
            </div>
        </div>

        <div class="card bg-secondary text-light border-0">
            <div class="card-body">
                <h5 class="mb-3"><i class="fa-solid fa-plus-circle"></i> Pievienot jaunu pierādījumu</h5>

                <form method="POST"
                    action="{{ route('cases.evidence.store', $case->id) }}"
                    enctype="multipart/form-data"
                    id="evidenceForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-solid fa-pen"></i> Apraksts</label>
                        <textarea name="description"
                            class="form-control bg-dark text-light border-0"
                            rows="3"
                            required
                            placeholder="Piem., 'Asins traips uz paklāja' vai 'Aizdomīga vēstule'..."></textarea>
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-info-circle"></i> Apraksti, kas šis ir par pierādījumu, kur tas atrasts un kāpēc tas ir svarīgs
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fa-solid fa-file"></i> Fails</label>
                        <input type="file"
                            id="fileInput"
                            name="file"
                            class="form-control bg-dark text-light border-0"
                            accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <small class="text-light mt-1 d-block">
                            <i class="fa-solid fa-upload"></i> Vari pievienot attēlus (JPG, PNG, GIF), PDF vai Word dokumentus
                        </small>
                    </div>

                    <div class="mb-3 d-none" id="imageBlock">
                        <label class="form-label"><i class="fa-solid fa-crop"></i> Iezīmē objektu</label>
                        <div class="image-wrapper" id="imageWrapper">
                            <img id="previewImage" style="max-width: 100%; display: none; cursor: crosshair;">
                            <div id="selectionBox" class="selection-box"></div>
                        </div>
                        <small class="text-secondary d-block mt-2">
                            <i class="fa-solid fa-mouse-pointer"></i> Nospied un velc ar peli, lai iezīmētu svarīgo zonu attēlā
                        </small>
                    </div>

                    <input type="hidden" name="key_object_area" id="key_object_area" value="">

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('cases.suspects', $case->id) }}"
                            class="btn btn-outline-light">
                            <i class="fa-solid fa-circle-arrow-left"></i> Atpakaļ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-circle-plus"></i> Pievienot pierādījumu
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-end mt-4 d-flex justify-content-between">
            <a href="{{ route('cases.my-cases') }}"
                class="btn btn-outline-light">
                <i class="fa-solid fa-right-from-bracket"></i> Iziet
            </a>
            <a href="{{ route('cases.questions', $case->id) }}"
                id="nextBtn"
                class="btn btn-success {{ count($evidence) < 2 ? 'disabled' : '' }}">
                Tālāk <i class="fa-solid fa-circle-arrow-right"></i>
            </a>
        </div>

    </main>

    @include('partials.footer')

    <div id="evidenceData"
        data-evidence-count="{{ count($evidence) }}"
        style="display: none;">
    </div>

    <script>
        const evidenceDataElement = document.getElementById('evidenceData');
        window.evidenceData = {
            evidenceCount: parseInt(evidenceDataElement.dataset.evidenceCount)
        };
    </script>

    <script src="{{ asset('js/constructor/evidence.js') }}"></script>
</body>

</html>