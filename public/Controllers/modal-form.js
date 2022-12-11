"strict mode";

const openModalForm = document.querySelectorAll(".open-modal-btn");
const closeModalForm = document.querySelectorAll(".close-modal");
const modalForm = document.querySelectorAll(".modal-form");
const overlay = document.querySelector(".overlay");
const body = document.querySelector("body");

const closeForm = () => {
  modalForm.forEach((modal) => modal.classList.add("hidden"));
  overlay.classList.add("hidden");
  body.classList.remove("max-height-form");
};

openModalForm.forEach((openBtn, i) => {
  openBtn.addEventListener("click", () => {
    modalForm[i].classList.remove("hidden");
    overlay.classList.remove("hidden");
    body.classList.add("max-height-form");
  });
});

closeModalForm.forEach((closeBtn, i) => {
  closeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    closeForm();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modalForm[i].classList.contains("hidden"))
      closeForm();
  });
});

overlay.addEventListener("click", () => closeForm(modalForm));
