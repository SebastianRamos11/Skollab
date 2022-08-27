// Elements
const form = document.querySelector('.form');
const formInput = document.querySelectorAll('.pass-input');
const inputPass = document.getElementById('pass');
const inputConfirmPass = document.getElementById('confirm-pass');

// Regular expressions
const regularExpressions = {
  pass: /^.{4,20}$/, // 4 a 20 digitos.
};

// Fields
const fields = {
  pass: false,
  confirmPass: false,
};

// Field validation

const correctField = function (state, message, field) {
  state.add('form__field-correct');
  state.remove('form__field-wrong');
  message.remove('form__field-error--active');
  fields[field] = true;
};
const wrongField = function (state, message, field) {
  state.add('form__field-wrong');
  state.remove('form__field-correct');
  message.add('form__field-error--active');
  fields[field] = false;
};

const validateField = function (expression, input, field) {
  const state = document.getElementById(`group-${field}`).classList;
  const message = document.querySelector(`#group-${field} .form__field-error`).classList;
  if (expression.test(input.value)) {
    correctField(state, message, field);
  } else {
    wrongField(state, message, field);
  }
};

// Password validator
const validatePass = function () {
  const state = document.getElementById(`group-confirm-pass`).classList;
  const message = document.querySelector(`#group-confirm-pass .form__field-error`).classList;

  if (inputPass.value === inputConfirmPass.value) {
    correctField(state, message, inputPass);
    fields['confirmPass'] = true;
  } else {
    wrongField(state, message, inputPass);
    fields['confirmPass'] = false;
  }
};

// Inputs Validation
const validateInput = function (e) {
  switch (e.target.name) {
    case 'pass':
      validateField(regularExpressions.pass, e.target, 'pass');
      validatePass();
      break;
    case 'confirm-pass':
      validatePass();
      break;
  }
};

formInput.forEach(input => {
  input.addEventListener('keyup', validateInput);
  input.addEventListener('blur', validateInput);
});

form.addEventListener('submit', e => {
  if (fields.pass && fields.confirmPass) {
    document.getElementById('form__error-message').classList.remove('form__error-message--active');
    e.defaultPrevented();
  } else {
    document.getElementById('form__error-message').classList.add('form__error-message--active');
    e.preventDefault();
  }
});
