<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - Risinājums</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    @php
        $editMode = $editMode ?? false;
    @endphp

    <main class="container my-5">

        <h1 class="text-center mb-4 fw-bold">
            Lietas: <strong class="text-light">"{{ $case->title }}"</strong> risinājums
        </h1>

        @if($editMode)
        <div class="alert alert-warning border-0 mb-4">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Pēc izmaiņu veikšanas lieta tiks atkārtoti nosūtīta moderācijai.
        </div>
        @endif

        {{-- PROGRESS --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>5. solis no 5</span>
                <span>Risinājums</span>
            </div>

            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: 100%;"></div>
            </div>
        </div>

        {{-- INFO --}}
        <div class="alert alert-dark border-0 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="display-6">
                    <i class="fa-solid fa-book-skull"></i>
                </div>

                <div>
                    <strong>Detektīv, laiks atklāt patiesību!</strong><br>

                    Šeit vari aprakstīt, kā spēlētājam bija iespējams atrisināt lietu,
                    kādi pavedieni bija svarīgi un kāpēc tieši šis aizdomās turamais ir vainīgais.<br>

                    Šis teksts tiks parādīts pēc lietas pabeigšanas.<br>

                    <small class="text-secondary">
                        <i class="fa-solid fa-lightbulb" style="color: #dabe69;"></i>
                        Padoms: paskaidro loģiku un sasaisti pierādījumus ar notikumiem!
                    </small>
                </div>
            </div>
        </div>

        {{-- CASE SUMMARY --}}
        <div class="card bg-secondary text-light border-0 mb-4">
            <div class="card-body">

                <h5 class="mb-4">
                    <i class="fa-solid fa-folder-open"></i>
                    Lietas kopsavilkums
                </h5>

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="p-3 rounded bg-dark h-100">
                            <h6 class="text-danger">
                                <i class="fa-solid fa-user-secret"></i>
                                Vainīgais
                            </h6>

                            <p class="mb-0">
                                {{ optional($case->suspect)->name ?? 'Nav izvēlēts' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 rounded bg-dark h-100">
                            <h6>
                                <i class="fa-solid fa-magnifying-glass"></i>
                                Pierādījumi
                            </h6>

                            <p class="mb-0">
                                {{ $case->evidence->count() }} pievienoti
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 rounded bg-dark h-100">
                            <h6>
                                <i class="fa-solid fa-circle-question"></i>
                                Jautājumi
                            </h6>

                            <p class="mb-0">
                                {{ $case->questions->count() }} pievienoti
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- SOLUTION FORM --}}
        <div class="card bg-secondary text-light border-0">
            <div class="card-body">

                <h5 class="mb-3">
                    <i class="fa-solid fa-pen"></i>
                    Risinājuma paskaidrojums
                </h5>

                <form method="POST"
                    action="{{ route('cases.solution.save', $case->id) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <label class="form-label">
                            <i class="fa-solid fa-file-lines"></i>
                            Paskaidrojums
                        </label>

                        <textarea
                            name="solution_explanation"
                            rows="10"
                            class="form-control bg-dark text-light border-0"
                            placeholder="Apraksti, kā spēlētājs varēja nonākt līdz pareizajai atbildei..."
                            required>{{ old('solution_explanation', $case->solution_explanation) }}</textarea>

                        <small class="text-light mt-2 d-block">
                            <i class="fa-solid fa-info-circle"></i>
                            Šis teksts palīdzēs spēlētājam saprast lietas loģiku un kļūdas
                        </small>

                    </div>

                    <div class="d-flex justify-content-between">

                        <a href="{{ route('cases.questions', $case->id) }}"
                            class="btn btn-outline-light">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                            Atpakaļ
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Saglabāt paskaidrojumu
                        </button>

                    </div>

                </form>

            </div>
        </div>

        {{-- FINISH --}}
        <div class="text-end mt-4 d-flex justify-content-between">

            <a href="{{ route('cases.my-cases') }}"
                class="btn btn-outline-light">
                <i class="fa-solid fa-right-from-bracket"></i>
                Iziet
            </a>

            <form method="POST"
                action="{{ route('cases.submit.final', $case->id) }}">

                @csrf

                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-circle-check"></i>
                    Pabeigt lietu
                </button>

            </form>

        </div>

    </main>

    @include('partials.footer')

</body>

</html>