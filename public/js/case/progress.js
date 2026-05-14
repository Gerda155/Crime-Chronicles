function updateProgress(opened, questionsUsed = null) {

    if (!window.caseData) return;

    const totalEvidence = window.caseData.totalEvidence || 0;

    // считаем реально раскрытые ответы
    const openedQuestions = document.querySelectorAll('.answer:not(.d-none)').length;

    const totalQuestions = document.querySelectorAll('.answer').length;

    const total = totalEvidence + totalQuestions;

    const done = opened + openedQuestions;

    let percent = total > 0
        ? (done / total) * 100
        : 0;

    percent = Math.min(100, Math.max(0, percent));

    const bar = document.querySelector('.progress-bar');

    if (bar) {
        bar.style.width = percent + '%';
        bar.innerText = Math.round(percent) + '%';
    }

    const token = document.querySelector('input[name="_token"]');

    if (token && window.caseData.caseId) {
        fetch('/progress/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token.value
            },
            body: JSON.stringify({
                case_id: window.caseData.caseId,
                opened_evidence: opened,
                questions_used: openedQuestions,
                score: document.getElementById('scoreInput')?.value || 0
            })
        });
    }
}