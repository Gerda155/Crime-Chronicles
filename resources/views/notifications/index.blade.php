<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paziņojumi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <h1 class="fw-bold mb-4 text-center">
            <i class="fa-solid fa-bell me-2"></i>
            Mani paziņojumi
        </h1>

        @include('notifications.partials.filters')

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="d-flex flex-column gap-3">

            @forelse($notifications as $notification)

            <div class="card rounded p-3 shadow-sm
    {{ !$notification->is_read ? 'border border-primary bg-dark' : 'bg-dark' }}">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="d-flex gap-3">
                        <div class="fs-3">

                            @if($notification->type === 'case_approved')
                            <i class="fa-solid fa-circle-check text-success"></i>

                            @elseif($notification->type === 'case_rejected')
                            <i class="fa-solid fa-circle-xmark text-danger"></i>

                            @elseif($notification->type === 'comment_received')
                            <i class="fa-solid fa-comments text-info"></i>

                            @elseif($notification->type === 'new_achievement')
                            <i class="fa-solid fa-trophy text-warning"></i>

                            @elseif($notification->type === 'rank_updated')
                            <i class="fa-solid fa-crown text-warning"></i>

                            @else
                            <i class="fa-solid fa-bell"></i>
                            @endif

                        </div>

                        @if(!$notification->is_read)
                        <span class="badge bg-primary mb-2">Jauns</span>
                        @endif

                        <div>

                            <div class="fw-bold mb-1 text-light">
                                {{ $notification->message }}
                            </div>

                            <small class="text-secondary">
                                {{ $notification->created_at->format('d.m.Y H:i') }}
                            </small>

                        </div>

                    </div>

                    <div class="d-flex gap-2">

                        @if(!$notification->is_read)

                        <form action="{{ route('notifications.read', $notification->id) }}"
                            method="POST">

                            @csrf
                            @method('PATCH')

                            <button class="btn btn-sm btn-outline-primary rounded"
                                title="Atzīmēt kā izlasītu">

                                <i class="fa-solid fa-check"></i>

                            </button>

                        </form>

                        @endif

                        <form action="{{ route('notifications.destroy', $notification->id) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger rounded"
                                title="Dzēst">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </div>

                </div>

            </div>

            @empty

            <div class="text-center text-secondary py-5">
                <i class="fa-solid fa-bell-slash fa-3x mb-3 d-block"></i>
                Tev vēl nav paziņojumu
            </div>

            @endforelse

        </div>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>

    </main>

    @include('partials.footer')

</body>

</html>