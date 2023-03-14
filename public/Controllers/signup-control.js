"strict mode";

// Selections

// Form
const form = document.getElementById("form");
const formInput = document.querySelectorAll("#form input");

// Controls
const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const progressStep = document.querySelectorAll(".progress-step");
const formStep = document.querySelectorAll(".step");
const instructor = document.querySelector(".rol__instructor");
const student = document.querySelector(".rol__student");

// Step counter
let formStepNum = 0;

// Regular expressions
const regularExpressions = {
  userId: /^\d{10}$/, // 10 numbers.
  userName: /^[a-zA-ZÀ-ÿ\s]{1,20}$/, // Letras y espacios, pueden llevar acentos.
  phone: /^\d{7,10}$/, // 7 a 10 numeros.
  email: /^[a-zA-Z0-9_.+-]+@+[a-zA-Z0-9_.+-]+.+[a-zA-Z0-9_.+-]$/,
  pass: /^.{4,20}$/, // 4 a 20 digitos.
};

const fields = {
  id: false,
  firstName: false,
  lastName: false,
  phone: false,
  email: false,
  pass: false,
  confirmPass: false,
};

// Field validation
const correctField = function (state, icon, message, field) {
  state.add("step__field-correct");
  state.remove("step__field-wrong");
  icon.add("fa-check-circle");
  icon.remove("fa-times-circle");
  message.remove("step__field-error--active");
  fields[field] = true;
};
const wrongField = function (state, icon, message, field) {
  state.add("step__field-wrong");
  state.remove("step__field-correct");
  icon.add("fa-times-circle");
  icon.remove("fa-check-circle");
  message.add("step__field-error--active");
  fields[field] = false;
};

const validateField = function (expression, input, field) {
  const state = document.getElementById(`group-${field}`).classList;
  const icon = document.querySelector(`#group-${field} i`).classList;
  const message = document.querySelector(
    `#group-${field} .step__field-error`
  ).classList;

  if (expression.test(input.value)) {
    correctField(state, icon, message, field);
  } else {
    wrongField(state, icon, message, field);
  }
};

// Inputs validation

const validateInput = function (e) {
  switch (e.target.name) {
    case "id":
      validateField(regularExpressions.userId, e.target, "id");
      break;
    case "firstName":
      validateField(regularExpressions.userName, e.target, "firstName");
      break;
    case "lastName":
      validateField(regularExpressions.userName, e.target, "lastName");
      break;
    case "phone":
      validateField(regularExpressions.phone, e.target, "phone");
      break;
    case "email":
      validateField(regularExpressions.email, e.target, "email");
      break;
    case "pass":
      validateField(regularExpressions.pass, e.target, "pass");
      validatePass();
      break;
    case "confirm-pass":
      validatePass();
      break;
  }
};

// Inputs validation
formInput.forEach((input) => {
  input.addEventListener("keyup", validateInput);
  input.addEventListener("blur", validateInput);
});

// Upper converter
function upper(e) {
  e.value = e.value.toUpperCase();
}

// Password validator
const validatePass = function () {
  const inputPass = document.getElementById("pass");
  const inputConfirmPass = document.getElementById("confirm-pass");
  const state = document.getElementById(`group-confirm-pass`).classList;
  const icon = document.querySelector(`#group-confirm-pass i`).classList;
  const message = document.querySelector(
    `#group-confirm-pass .step__field-error`
  ).classList;

  if (inputPass.value === inputConfirmPass.value) {
    correctField(state, icon, message, inputPass);
    fields["confirmPass"] = true;
  } else {
    wrongField(state, icon, message, inputPass);
    fields["confirmPass"] = false;
  }
};

// Rol switch
instructor.addEventListener("click", function () {
  instructor.style.background = "#0066FF";
  student.style.background = "#FFF";
});

student.addEventListener("click", function () {
  student.style.background = "#0066FF";
  instructor.style.background = "#FFF";
});

// Buttons
const updateFormSteps = function () {
  formStep.forEach((formStep) => {
    formStep.classList.contains("step--active");
    formStep.classList.remove("step--active");
  });
  formStep[formStepNum].classList.add("step--active");
};

const updateProgressBar = function () {
  progressStep.forEach((progressStep, i) => {
    if (i < formStepNum + 1) {
      progressStep.classList.add("progress-step--active");
    } else {
      progressStep.classList.remove("progress-step--active");
    }
  });

  const progressActive = document.querySelectorAll(".progress-step--active");
  progress.style.width =
    ((progressActive.length - 1) / (progressStep.length - 1)) * 100 + "%";
};

nextBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    formStepNum++;
    updateFormSteps();
    updateProgressBar();
  });
});

prevBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    formStepNum--;
    updateFormSteps();
    updateProgressBar();
  });
});

form.addEventListener("submit", (e) => {
  const rolOption = document.getElementsByName("rol");

  if (
    fields.id &&
    fields.firstName &&
    fields.lastName &&
    fields.phone &&
    fields.email &&
    fields.pass &&
    fields.confirmPass &&
    (rolOption[0].checked || rolOption[1].checked)
  ) {
    document.querySelectorAll(".step__field-correct").forEach((icon) => {
      icon.classList.remove("step__field-correct");
    });
    document
      .getElementById("step__error-message")
      .classList.remove("step__error-message--active");
    e.defaultPrevented();
  } else {
    document
      .getElementById("step__error-message")
      .classList.add("step__error-message--active");
    e.preventDefault();
  }
});
