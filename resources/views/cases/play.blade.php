<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">
    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">
        <div class="container my-5">
            <h1>{{ $case->title }}</h1>
            <p>{{ $case->description }}</p>

            <h3>Pierādījumi</h3>
            <div class="row mb-4">
                @foreach($evidence as $item)
                <div class="col-md-4 mb-3">
                    @if($item->type === 'image')
                    <img src="{{ asset('storage/' . $item->content) }}" class="img-fluid rounded">
                    @else
                    <p>{{ $item->description }}</p>
                    @endif
                </div>
                @endforeach
            </div>

            <h3>Aizdomās turamie</h3>
            <form action="{{ route('cases.submit', $case->id) }}" method="POST">
                @csrf
                @foreach($suspects as $suspect)
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="suspect_id" value="{{ $suspect->id }}" id="suspect-{{ $suspect->id }}">
                    <label class="form-check-label" for="suspect-{{ $suspect->id }}">
                        {{ $suspect->name }} - {{ $suspect->description }}
                    </label>
                </div>
                @endforeach
                <button type="submit" class="btn btn-success mt-3">Iesniegt atbildi</button>
            </form>

            @if(session('status'))
            <div class="alert alert-info mt-3">
                {{ session('status') }}
            </div>
            @endif
        </div>

    </main>

    @include('partials.footer')
</body>

</html>