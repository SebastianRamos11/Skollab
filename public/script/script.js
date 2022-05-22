'strict mode';

const prevBtns = document.querySelectorAll('.btn-prev');
const nextBtns = document.querySelectorAll('.btn-next');
const progress = document.getElementById('progress');
const progressStep = document.querySelectorAll('.progress-step');
const formStep = document.querySelectorAll('.step');
const instructor = document.querySelector('.rol__instructor');
const aprendiz = document.querySelector('.rol__aprendiz');
// const firstName = document.getElementById('firstName').value;

let formStepNum = 0;

// Rol switch

instructor.addEventListener('click', function () {
  instructor.style.background = '#0066FF';
  aprendiz.style.background = '#FFF';
});

aprendiz.addEventListener('click', function () {
  aprendiz.style.background = '#0066FF';
  instructor.style.background = '#FFF';
});

// Buttons

const updateFormSteps = function () {
  formStep.forEach(formStep => {
    formStep.classList.contains('step--active');
    formStep.classList.remove('step--active');
  });
  formStep[formStepNum].classList.add('step--active');
};

const updateProgressBar = function () {
  progressStep.forEach((progressStep, i) => {
    if (i < formStepNum + 1) {
      progressStep.classList.add('progress-step--active');
    } else {
      progressStep.classList.remove('progress-step--active');
    }
  });

  const progressActive = document.querySelectorAll('.progress-step--active');
  progress.style.width = ((progressActive.length - 1) / (progressStep.length - 1)) * 100 + '%';
};

nextBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    formStepNum++;
    updateFormSteps();
    updateProgressBar();
  });
});

prevBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    formStepNum--;
    updateFormSteps();
    updateProgressBar();
  });
});
