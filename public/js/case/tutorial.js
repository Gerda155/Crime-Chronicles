const TutorialSystem = {

    isActive: window.caseData.isTutorial,

    currentStep: 0,

    overlay: null,

    tutorialBox: null,

    highlightedElement: null,

    stepsCompleted: [],

    steps: [
        {
            title: "Sveicināts!",
            text: "Šī ir mācību lieta. Es Tevi iepazīstināšu ar spēli.",
            trigger: null,
            highlightSelector: null,
            position: "center"
        },

        {
            title: "1. solis",
            text: "Noklikšķini uz pogas 'Atvērt pierādījumu'",
            trigger: "evidence_click",
            highlightSelector: ".reveal-btn",
            position: "bottom"
        },

        {
            title: "2. solis",
            text: "Atrodi slēpto objektu bildē un noklikšķini uz tā",
            trigger: "hidden_object",
            highlightSelector: ".evidence-img-wrapper",
            position: "top"
        },

        {
            title: "3. solis",
            text: "Atver vēl vienu pierādījumu",
            trigger: "evidence_count_2",
            highlightSelector: ".reveal-btn",
            position: "bottom"
        },

        {
            title: "4. solis",
            text: "Uzdod jautājumu aizdomās turamajam",
            trigger: "ask_question",
            highlightSelector: ".ask-btn",
            position: "right"
        },

        {
            title: "5. solis",
            text: "Izvēlies aizdomās turamo",
            trigger: "select_suspect",
            highlightSelector: ".suspect-card",
            position: "bottom"
        },

        {
            title: "Apsveicu!",
            text: "Tagad esi gatavs risināt īstas lietas!",
            trigger: null,
            highlightSelector: null,
            position: "center"
        }
    ],

    init() {

        if (!this.isActive) return;

        this.overlay = document.createElement('div');
        this.overlay.className = 'tutorial-overlay';

        document.body.appendChild(this.overlay);

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

        this.removeHighlight();

        let buttonsHtml = '';

        if (stepIndex < this.steps.length - 1) {

            buttonsHtml = step.trigger
                ? '<button class="tutorial-skip">Izlaist</button>'
                : '<button class="tutorial-next">Nākamais ➜</button>';

        } else {

            buttonsHtml = '<button class="tutorial-finish">Sākt spēli!</button>';
        }

        this.tutorialBox.innerHTML =
            '<h4>' + step.title + '</h4>' +
            '<p>' + step.text + '</p>' +
            buttonsHtml;

        const nextBtn = this.tutorialBox.querySelector('.tutorial-next');
        const finishBtn = this.tutorialBox.querySelector('.tutorial-finish');
        const skipBtn = this.tutorialBox.querySelector('.tutorial-skip');

        if (nextBtn) {
            nextBtn.addEventListener('click', () => this.nextStep());
        }

        if (finishBtn) {
            finishBtn.addEventListener('click', () => this.end());
        }

        if (skipBtn) {

            skipBtn.addEventListener('click', () => {

                this.currentStep = this.steps.length - 1;

                this.nextStep();
            });
        }

        if (step.highlightSelector) {

            const element = document.querySelector(step.highlightSelector);

            if (element) {

                this.highlightElementFn(element);

                this.positionBox(element, step.position);
            }

        } else {

            this.positionBox(null, 'center');
        }
    },

    highlightElementFn(element) {

        this.removeHighlight();

        this.highlightedElement = element;

        element.classList.add('tutorial-highlight');

        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    },

    removeHighlight() {

        if (!this.highlightedElement) return;

        this.highlightedElement.classList.remove('tutorial-highlight');

        this.highlightedElement = null;
    },

    positionBox(targetElement, position) {

        if (!targetElement || position === 'center') {

            this.tutorialBox.style.position = 'fixed';
            this.tutorialBox.style.top = '50%';
            this.tutorialBox.style.left = '50%';
            this.tutorialBox.style.transform = 'translate(-50%, -50%)';

            return;
        }

        const rect = targetElement.getBoundingClientRect();

        this.tutorialBox.style.position = 'fixed';
        this.tutorialBox.style.top = rect.bottom + 20 + 'px';
        this.tutorialBox.style.left = rect.left + 'px';
    },

    trigger(triggerName) {

        if (!this.isActive) return;

        const currentStep = this.steps[this.currentStep];

        if (
            currentStep &&
            currentStep.trigger === triggerName &&
            !this.stepsCompleted[this.currentStep]
        ) {

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

        this.isActive = false;

        this.overlay?.remove();

        this.tutorialBox?.remove();

        this.removeHighlight();
    }
};

document.addEventListener('DOMContentLoaded', function () {
    TutorialSystem.init();
});