const modifyGrade = document.querySelector(".user-evidence__modify-grade");
const submitBtn = document.querySelector(".calification-form__btn-submit");
const observation = document.querySelector(
  ".calification-form__observation-input"
);
const calification = document.querySelector(
  ".calification-form__grade-input--inp"
);

modifyGrade.addEventListener("click", () => {
  submitBtn.classList.remove("hidden");
  calification.removeAttribute("disabled");
  observation.removeAttribute("disabled");
});
