const createBtn = document.querySelector(".create-button");
const closeBtn = document.querySelector(".btn-close");
const createForm = document.querySelector(".upload-form");
const contentBody = document.querySelector(".main-content");
const overlay = document.querySelector(".overlay");

const closeForm = () => {
  createForm.classList.add("hidden");
  overlay.classList.add("hidden");
  contentBody.classList.remove("max-height-form");
};

createBtn?.addEventListener("click", () => {
  createForm.classList.remove("hidden");
  overlay.classList.remove("hidden");
  contentBody.classList.add("max-height-form");
});

closeBtn?.addEventListener("click", closeForm);
overlay?.addEventListener("click", closeForm);
document?.addEventListener("keydown", function (e) {
  if (e.key === "Escape" && !createForm.classList.contains("hidden")) {
    closeForm();
  }
});
