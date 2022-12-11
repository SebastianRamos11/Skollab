const randomNumBtn = document.querySelectorAll(".random-number");
const randomNumInput = document.querySelectorAll(".random-number-input");

randomNumBtn.forEach((btn, i) => {
  btn.addEventListener("click", () => {
    randomNumInput[i].value = Math.trunc(Math.random() * 999999);
  });
});
