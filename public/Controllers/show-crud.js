const crud = document.querySelectorAll(".crud");
const openCrudBtn = document.querySelectorAll(".crud-option__btn");

openCrudBtn.forEach((e, i) => {
  openCrudBtn[i].addEventListener("click", () => {
    crud[i].classList.remove("hidden");
    for (let j = 0; j < crud.length; j++) {
      if (crud[j] === crud[i]) continue;
      crud[j].classList.add("hidden");
    }
  });
});
