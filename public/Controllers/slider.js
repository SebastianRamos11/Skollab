const sliders = document.querySelectorAll(".slider__body");
const arrowBefore = document.querySelector("#before");
const arrowNext = document.querySelector("#next");
let value;

const changePosition = function (change) {
  const currentElement = +document.querySelector(".slider__body--show").dataset
    .id;
  value = currentElement;
  value += change;
  console.log("Elemento activo: ", currentElement);
  console.log("Elemento siguiente: ", value);
  if (value === 0 || value === sliders.length + 1) {
    value = value === 0 ? sliders.length : 1;
  }
  sliders[currentElement - 1].classList.toggle("slider__body--show");
  sliders[value - 1].classList.toggle("slider__body--show");
};

arrowBefore.addEventListener("click", () => changePosition(-1));
arrowNext.addEventListener("click", () => changePosition(1));
