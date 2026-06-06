const TutorialSystem = {
    isActive: false,
    currentStep: 0,
    tutorialBox: null,
    highlightedElement: null,
    stepsCompleted: [],
    evidenceCount: 0,
    isWaitingForTrigger: false,
    caseId: null,

    steps: [
        {
            title: "Sveicināts!",
            text: "Šī ir apmācības lieta. Es parādīšu, kā notiek izmeklēšana Crime Chronicles.",
            trigger: null,
            highlightSelector: null,
            position: "center"
        },
        {
            title: "1. solis - Izpēti pierādījumus",
            text: "Atver pirmo pierādījumu, lai sāktu izmeklēšanu.",
            trigger: "first_evidence_opened",
            highlightSelector: ".reveal-btn",
            position: "bottom"
        },
        {
            title: "2. solis - Savāc informāciju",
            text: "Labi! Tagad atver vēl vienu pierādījumu. Jo vairāk informācijas savāksi, jo vieglāk būs atrast vainīgo.",
            trigger: "second_evidence_opened",
            highlightSelector: ".reveal-btn",
            position: "bottom"
        },
        {
            title: "3. solis - Izvēlies aizdomās turamo",
            text: "Tagad izvēlies kādu aizdomās turamo, lai sāktu viņa iztaujāšanu.",
            trigger: "select_suspect",
            highlightSelector: ".suspect-card",
            position: "bottom"
        },
        {
            title: "4. solis - Uzdod jautājumu",
            text: "Uzdod aizdomās turamajam jautājumu un izlasi viņa atbildi.",
            trigger: "ask_question",
            highlightSelector: ".ask-btn",
            position: "right"
        },
        {
            title: "5. solis - Pieņem lēmumu",
            text: "Kad esi pārliecināts par savu izvēli, vari iesniegt atbildi.",
            trigger: "ready_to_submit",
            highlightSelector: "#submitBtn",
            position: "top"
        }
    ],

    isTutorialCompleted() {
        if (!this.caseId) return false;
        
        const completed = localStorage.getItem(`tutorial_completed_${this.caseId}`);
        if (completed === 'true') {
            console.log('Tutorial already completed for this case');
            return true;
        }
        
        return false;
    },

    saveTutorialCompletion() {
        if (this.caseId) {
            localStorage.setItem(`tutorial_completed_${this.caseId}`, 'true');
            console.log('Tutorial completion saved for case', this.caseId);
        }
        
        if (window.caseData && window.caseData.id) {
            fetch('/complete-tutorial', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                    caseId: window.caseData.id,
                    userId: window.caseData.userId 
                })
            }).catch(err => console.error('Failed to save tutorial completion:', err));
        }
    },

    init() {
        this.caseId = window.caseData?.id || null;

        const shouldShowTutorial = window.caseData?.isTutorial || false;
        
        if (!shouldShowTutorial) {
            console.log('Tutorial not required for this case');
            return;
        }

        if (this.isTutorialCompleted()) {
            console.log('Tutorial already completed, skipping');
            return;
        }
        
        this.isActive = true;
        console.log('Tutorial starting...');
        
        this.currentStep = 0;
        this.stepsCompleted = [];
        this.evidenceCount = 0;
        this.isWaitingForTrigger = false;

        if (this.tutorialBox) this.tutorialBox.remove();
        this.createTutorialBox();
        this.start();
    },

    createTutorialBox() {
        this.tutorialBox = document.createElement('div');
        this.tutorialBox.className = 'tutorial-box';
        document.body.appendChild(this.tutorialBox);
    },

    showStep(stepIndex) {
        const step = this.steps[stepIndex];
        if (!step) return;

        console.log('Showing step', stepIndex, ':', step.title);
        
        this.removeHighlight();
        this.renderStep(step, stepIndex);
        
        if (step.trigger) {
            this.isWaitingForTrigger = true;
        } else {
            this.isWaitingForTrigger = false;
        }
    },

    renderStep(step, stepIndex) {
        let buttonsHtml = '';
        
        if (stepIndex < this.steps.length - 1) {
            if (step.trigger) {
                buttonsHtml = '<button class="tutorial-skip">Izlaist</button>';
            } else {
                buttonsHtml = '<button class="tutorial-next">Nākamais ➜</button>';
            }
        } else {
            buttonsHtml = '<button class="tutorial-finish">Sākt spēli!</button>';
        }

        this.tutorialBox.innerHTML = `
            <h4>${step.title}</h4>
            <p>${step.text}</p>
            ${buttonsHtml}
        `;

        let element = null;
        if (step.highlightSelector) {
            element = document.querySelector(step.highlightSelector);
        }

        if (element && step.highlightSelector) {
            this.highlightElementFn(element);
            this.positionBox(element, step.position);
        } else {
            this.positionBox(null, 'center');
        }

        const nextBtn = this.tutorialBox.querySelector('.tutorial-next');
        const finishBtn = this.tutorialBox.querySelector('.tutorial-finish');
        const skipBtn = this.tutorialBox.querySelector('.tutorial-skip');

        if (nextBtn) nextBtn.onclick = () => this.nextStep();
        if (finishBtn) finishBtn.onclick = () => this.end();
        if (skipBtn) {
            skipBtn.onclick = () => {
                if (this.stepsCompleted[this.currentStep] !== true) {
                    this.stepsCompleted[this.currentStep] = true;
                    this.currentStep++;
                    if (this.currentStep >= this.steps.length) {
                        this.end();
                    } else {
                        this.showStep(this.currentStep);
                    }
                }
            };
        }
    },

    highlightElementFn(element) {
        this.removeHighlight();
        this.highlightedElement = element;
        element.classList.add('tutorial-highlight');

        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
            inline: 'center'
        });
    },

    removeHighlight() {
        if (this.highlightedElement) {
            this.highlightedElement.classList.remove('tutorial-highlight');
            this.highlightedElement = null;
        }
    },

    positionBox(targetElement, position) {
        if (!targetElement || position === 'center') {
            this.tutorialBox.style.position = 'fixed';
            this.tutorialBox.style.top = '50%';
            this.tutorialBox.style.left = '50%';
            this.tutorialBox.style.transform = 'translate(-50%, -50%)';
            return;
        }

        setTimeout(() => {
            const rect = targetElement.getBoundingClientRect();
            const boxRect = this.tutorialBox.getBoundingClientRect();
            const margin = 15;

            let top, left;

            switch (position) {
                case 'bottom':
                    top = rect.bottom + margin;
                    left = rect.left + (rect.width / 2) - (boxRect.width / 2);
                    break;
                case 'top':
                    top = rect.top - boxRect.height - margin;
                    left = rect.left + (rect.width / 2) - (boxRect.width / 2);
                    break;
                case 'right':
                    top = rect.top + (rect.height / 2) - (boxRect.height / 2);
                    left = rect.right + margin;
                    break;
                default:
                    top = rect.bottom + margin;
                    left = rect.left;
            }

            if (top < margin) top = margin;
            if (top + boxRect.height > window.innerHeight - margin) {
                top = window.innerHeight - boxRect.height - margin;
            }
            if (left < margin) left = margin;
            if (left + boxRect.width > window.innerWidth - margin) {
                left = window.innerWidth - boxRect.width - margin;
            }

            this.tutorialBox.style.top = top + 'px';
            this.tutorialBox.style.left = left + 'px';
            this.tutorialBox.style.transform = 'none';

            this.addArrow(targetElement, position);
        }, 100);
    },

    addArrow(targetElement, position) {
        const oldArrow = this.tutorialBox.querySelector('.tutorial-arrow');
        if (oldArrow) oldArrow.remove();

        const arrow = document.createElement('div');
        arrow.className = `tutorial-arrow ${position}`;

        const boxRect = this.tutorialBox.getBoundingClientRect();
        const targetRect = targetElement.getBoundingClientRect();

        switch (position) {
            case 'top':
                arrow.style.bottom = '-8px';
                arrow.style.left = (targetRect.left + targetRect.width / 2 - boxRect.left) + 'px';
                break;
            case 'bottom':
                arrow.style.top = '-8px';
                arrow.style.left = (targetRect.left + targetRect.width / 2 - boxRect.left) + 'px';
                break;
            case 'left':
                arrow.style.right = '-8px';
                arrow.style.top = (targetRect.top + targetRect.height / 2 - boxRect.top) + 'px';
                break;
            case 'right':
                arrow.style.left = '-8px';
                arrow.style.top = (targetRect.top + targetRect.height / 2 - boxRect.top) + 'px';
                break;
        }

        this.tutorialBox.appendChild(arrow);
    },

    markEvidenceOpened(btn) {
        this.evidenceCount++;
        console.log('Evidence opened count:', this.evidenceCount);
        
        if (this.evidenceCount === 1) {
            this.trigger('first_evidence_opened');
        } else if (this.evidenceCount === 2) {
            this.trigger('second_evidence_opened');
        }
    },

    trigger(triggerName) {
        console.log('Trigger received:', triggerName, 'Current step:', this.currentStep, 'Waiting:', this.isWaitingForTrigger);

        if (!this.isActive) return;
        
        const currentStep = this.steps[this.currentStep];
        
        if (currentStep && currentStep.trigger === triggerName && !this.stepsCompleted[this.currentStep]) {
            console.log('✓ Trigger matched! Moving to next step');
            this.stepsCompleted[this.currentStep] = true;
            this.currentStep++;
            this.isWaitingForTrigger = false;

            if (this.currentStep >= this.steps.length) {
                this.end();
            } else {
                this.showStep(this.currentStep);
            }
        } else {
            console.log('Trigger not matched or already completed');
        }
    },

    nextStep() {
        if (this.currentStep >= this.steps.length - 1) {
            this.end();
            return;
        }
        
        if (!this.stepsCompleted[this.currentStep]) {
            this.stepsCompleted[this.currentStep] = true;
            this.currentStep++;
            this.showStep(this.currentStep);
        }
    },

    start() {
        this.currentStep = 0;
        this.stepsCompleted = [];
        this.evidenceCount = 0;
        this.isWaitingForTrigger = false;
        this.showStep(0);
    },

    end() {
        console.log('Tutorial ended');
        
        this.saveTutorialCompletion();
        
        this.isActive = false;
        if (this.tutorialBox) this.tutorialBox.remove();
        this.removeHighlight();
        this.tutorialBox = null;

        if (typeof showSmallNotification === 'function') {
            showSmallNotification('Apmācība pabeigta! Tagad vari sākt izmeklēšanu!', 'success');
        }
    }
};

function triggerTutorial(event) {
    if (typeof TutorialSystem !== 'undefined' && TutorialSystem && typeof TutorialSystem.trigger === 'function') {
        TutorialSystem.trigger(event);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing tutorial...');
    TutorialSystem.init();
});