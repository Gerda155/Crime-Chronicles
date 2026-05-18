<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Chronicles - {{ $case->title }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body class="bg-dark text-light">

    @include('partials.header')
    @include('partials.burger')

    <main class="container my-5">

        <div class="mb-5 text-center">
            <h1 class="display-4">{{ $case->title }}</h1>
            <p class="lead">{{ $case->description }}</p>
        </div>

        @include('cases.partials.play.progress')
        @include('cases.partials.play.evidence')
        @include('cases.partials.play.suspects')

    </main>

    @include('cases.partials.play.modals.answer')
    @include('cases.partials.play.modals.rating')
    @include('cases.partials.play.modals.achievement')
    @include('cases.partials.play.modals.image')

    @include('partials.footer')

    <div id="case-data"
        data-case-id="{{ $case->id }}"
        data-total-evidence="{{ count($evidence) }}"
        data-total-questions="{{ count($questions) }}"
        data-is-tutorial="{{ isset($isTutorial) && $isTutorial ? 'true' : 'false' }}">
    </div>

    <script>
        const caseDataElement = document.getElementById('case-data');
        window.caseData = {
            caseId: parseInt(caseDataElement.dataset.caseId),
            totalEvidence: parseInt(caseDataElement.dataset.totalEvidence),
            totalQuestions: parseInt(caseDataElement.dataset.totalQuestions),
            isTutorial: caseDataElement.dataset.isTutorial === 'true'
        };
    </script>

    <script src="{{ asset('js/case/tutorial.js') }}"></script>
    <script src="{{ asset('js/case/image-modal.js') }}"></script>
    <script src="{{ asset('js/case/questions.js') }}"></script>
    <script src="{{ asset('js/case/suspects.js') }}"></script>
    <script src="{{ asset('js/case/progress.js') }}"></script>
    <script src="{{ asset('js/case/notifications.js') }}"></script>
    <script src="{{ asset('js/case/rating.js') }}"></script>
    <script src="{{ asset('js/case/evidence.js') }}"></script>
    <script src="{{ asset('js/case/achievement.js') }}"></script>

</body>

</html>