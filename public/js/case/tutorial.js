const TutorialSystem = {

    isActive: window.caseData?.isTutorial || false,
    currentStep: 0,
    tutorialBox: null,
    highlightedElement: null,
    stepsCompleted: [],
    evidenceCount: 0,

    steps: [
        {
            title: "Sveicināts! 👋",
            text: "Šī ir izmeklēšanas apmācība. Nākamajos soļos es Tev parādīšu, kā strādāt ar pierādījumiem.",
            trigger: null,
            highlightSelector: null,
            position: "center"
        },
        {
            title: "1. solis - Atvērt pierādījumu",
            text: "Noklikšķini uz pogas 'Atvērt pierādījumu'",
            trigger: "evidence_click",
            highlightSelector: ".reveal-btn",
            position: "bottom"
        },
        {
            title: "2. solis - Atrast slēpto objektu",
            text: "Noklikšķini uz attēla, lai to atvērtu, un atrodi slēpto objektu",
            trigger: "hidden_object_found",
            highlightSelector: ".evidence-img-wrapper img",
            position: "top"
        },
        {
            title: "3. solis - Atvērt vēl vienu pierādījumu",
            text: "Lieliski! Tagad atver citu pierādījumu",
            trigger: "second_evidence_opened",
            highlightSelector: ".reveal-btn",
            position: "bottom"
        },
        {
            title: "4. solis - Uzdot jautājumu",
            text: "Tagad uzdod jautājumu aizdomās turamajam",
            trigger: "ask_question",
            highlightSelector: ".ask-btn",
            position: "right"
        },
        {
            title: "5. solis - Izvēlēties aizdomās turamo",
            text: "Izvēlies, kurš, tavuprāt, ir vainīgais",
            trigger: "select_suspect",
            highlightSelector: ".suspect-card",
            position: "bottom"
        },
        {
            title: "Apsveicu! 🎉",
            text: "Tagad esi gatavs risināt īstas lietas! Veiksmi detektīv!",
            trigger: null,
            highlightSelector: null,
            position: "center"
        }
    ],

    init() {
        if (!this.isActive) return;

        console.log('Tutorial starting...');
        
        this.currentStep = 0;
        this.stepsCompleted = [];
        this.evidenceCount = 0;
        
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

        console.log('Step', stepIndex, ':', step.title);
        
        this.removeHighlight();
        this.renderStep(step, stepIndex);
    },

    renderStep(step, stepIndex) {
        let buttonsHtml = '';
        if (stepIndex < this.steps.length - 1) {
            buttonsHtml = step.trigger
                ? '<button class="tutorial-skip">Izlaist</button>'
                : '<button class="tutorial-next">Nākamais ➜</button>';
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

        if (element) {
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
                this.currentStep = this.steps.length - 1;
                this.nextStep();
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

            switch(position) {
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

        switch(position) {
            case 'top':
                arrow.style.bottom = '-8px';
                arrow.style.left = (targetRect.left + targetRect.width/2 - boxRect.left) + 'px';
                break;
            case 'bottom':
                arrow.style.top = '-8px';
                arrow.style.left = (targetRect.left + targetRect.width/2 - boxRect.left) + 'px';
                break;
            case 'left':
                arrow.style.right = '-8px';
                arrow.style.top = (targetRect.top + targetRect.height/2 - boxRect.top) + 'px';
                break;
            case 'right':
                arrow.style.left = '-8px';
                arrow.style.top = (targetRect.top + targetRect.height/2 - boxRect.top) + 'px';
                break;
        }

        this.tutorialBox.appendChild(arrow);
    },

    trigger(triggerName) {
        console.log('Trigger:', triggerName, 'Current step:', this.currentStep);
        
        if (!this.isActive) return;

        const currentStep = this.steps[this.currentStep];
        
        if (currentStep && currentStep.trigger === triggerName && !this.stepsCompleted[this.currentStep]) {
            console.log('✓ Step completed! Moving to next step');
            this.stepsCompleted[this.currentStep] = true;
            this.currentStep++;

            if (this.currentStep >= this.steps.length) {
                this.end();
            } else {
                this.showStep(this.currentStep);
            }
        }
    },

    nextStep() {
        this.stepsCompleted[this.currentStep] = true;
        this.currentStep++;
        if (this.currentStep >= this.steps.length) {
            this.end();
        } else {
            this.showStep(this.currentStep);
        }
    },

    start() {
        this.currentStep = 0;
        this.stepsCompleted = [];
        this.showStep(0);
    },

    end() {
        console.log('Tutorial ended');
        this.isActive = false;
        if (this.tutorialBox) this.tutorialBox.remove();
        this.removeHighlight();
        this.tutorialBox = null;
    }
};

// Запуск
document.addEventListener('DOMContentLoaded', function () {
    TutorialSystem.init();
});