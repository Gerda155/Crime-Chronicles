<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Aizdomās turamie</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold text-pink">
            Aizdomās turamie
        </h1>

        {{-- ПРОГРЕСС --}}
        <div class="text-center mb-4 text-secondary">
            Lieta: <strong class="text-light">{{ $case->title }}</strong>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- СПИСОК --}}
                <form method="POST" action="{{ route('cases.suspects.setAnswer', $case->id) }}">
                    @csrf

                    <div class="card bg-secondary text-light border-0 mb-4">
                        <div class="card-body">

                            <h5>Esošie aizdomās turamie</h5>

                            @foreach($suspects as $suspect)
                            <div class="border-bottom py-3 d-flex gap-3 align-items-center">

                                @if($suspect->image_path)
                                <img src="{{ asset($suspect->image_path) }}"
                                    class="rounded"
                                    width="60"
                                    height="60">
                                @endif

                                <div class="flex-grow-1">
                                    <strong>{{ $suspect->name }}</strong><br>
                                    <small class="text-muted">{{ $suspect->description }}</small>
                                </div>

                                {{-- 👇 ВЫБОР ВИНОВНОГО --}}
                                <div>
                                    <input type="radio"
                                        name="answer_id"
                                        value="{{ $suspect->id }}"
                                        {{ $case->answer_id == $suspect->id ? 'checked' : '' }}>
                                </div>

                            </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Saglabāt vainīgo
                        </button>
                    </div>
                </form>

                {{-- ФОРМА --}}
                <div class="card bg-secondary text-light border-0">
                    <div class="card-body">

                        <form method="POST"
                            action="{{ route('cases.suspects.store', $case->id) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Vārds</label>
                                <input type="text" name="name"
                                    class="form-control bg-dark text-light border-0"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Apraksts</label>
                                <textarea name="description"
                                    class="form-control bg-dark text-light border-0"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attēls</label>
                                <input type="file"
                                    name="image"
                                    class="form-control bg-dark text-light border-0">
                            </div>

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('cases.my-cases') }}"
                                    class="btn btn-outline-light">
                                    Iziet
                                </a>

                                <button type="submit"
                                    class="btn btn-primary">
                                    Pievienot
                                </button>

                            </div>

                        </form>

                    </div>
                </div>

                {{-- NEXT STEP --}}
                <div class="text-end mt-4">
                    <a href="/cases/{{ $case->id }}/evidence"
                        class="btn btn-success">
                        Tālāk →
                    </a>
                </div>

            </div>
        </div>

    </main>

</body>

</html>