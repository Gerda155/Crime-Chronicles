function updateProgress(opened, questionsUsed = 0) {
    if (!window.caseData) {
        console.error('window.caseData is not defined');
        return;
    }
    
    const totalEvidence = window.caseData.totalEvidence;
    const totalQuestions = window.caseData.totalQuestions;
    
    if (!totalEvidence || totalEvidence === 0) {
        console.warn('totalEvidence is 0');
        return;
    }
    
    const evidencePercent = (opened / totalEvidence) * 50;
    const questionsPercent = (questionsUsed / totalQuestions) * 50;
    
    let percent = evidencePercent + questionsPercent;
    percent = Math.min(percent, 100);
    percent = Math.max(percent, 0);
    
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
                questions_used: questionsUsed,
                score: document.getElementById('scoreInput')?.value || 0
            })
        }).catch(err => console.error('Progress update error:', err));
    }
}