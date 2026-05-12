function updateProgress(opened, questionsUsed = 0) {

    const total = window.caseData.totalEvidence + window.caseData.totalQuestions;

    const completed = opened + questionsUsed;

    let percent = total > 0
        ? (completed / total) * 100
        : 0;

    percent = Math.min(percent, 100);

    const bar = document.querySelector('.progress-bar');

    if (bar) {
        bar.style.width = percent + '%';
        bar.innerText = Math.round(percent) + '%';
    }

    const token = document.querySelector('input[name="_token"]');

    if (!token) return;

    fetch('/progress/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token.value
        },
        body: JSON.stringify({
            case_id: window.caseData.caseId,
            opened_evidence: opened,
            questions_used: questionsUsed,
            score: document.getElementById('scoreInput')?.value || 0
        })
    });
}