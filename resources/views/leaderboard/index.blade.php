<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 detektīvi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="text-light">
    @include('partials.header')
    @include('partials.burger')

    <div class="container my-5">
        <h1 class="text-center mb-4">Top 10 detektīvi</h1>

        <div class="card bg-dark border-secondary shadow-sm mx-auto p-4"
             style="max-width: 1000px;">

            <table class="table table-dark table-hover align-middle text-center mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Detektīvs</th>
                        <th>Ačīvmenti</th>
                        <th>Kopš</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topDetectives as $index => $user)
                        <tr class="{{ $index === 0 ? 'table-warning text-dark fw-bold' : '' }}">
                            <td>{{ $index + 1 }}</td>

                            <td class="text-start">
                                <div class="d-flex align-items-center gap-3">
                                    <img
                                        src="{{ $user->avatar
                                            ? asset('storage/'.$user->avatar)
                                            : asset('images/avatar-placeholder.jpg') }}"
                                        class="rounded-circle border border-secondary"
                                        width="48"
                                        height="48"
                                        style="object-fit: cover;"
                                    >
                                    <div>
                                        <div>{{ $user->name }}</div>
                                        <small class="text-secondary">
                                            {{ '@' . $user->username }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                {{ $user->achievements_count }}
                            </td>

                            <td class="text-secondary">
                                {{ $user->created_at->format('d.m.Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @include('partials.footer')
</body>
</html>
