const file = document.querySelector("#file");
const createBtn = document.querySelector(".create-button");
const closeBtn = document.querySelector(".btn-close");
const createForm = document.querySelector(".upload-form");
const contentBody = document.querySelector(".main-content");
const overlay = document.querySelector(".overlay");

file.addEventListener("change", (e) => {
  // Get the selected file
  const [file] = e.target.files;
  // Get the file name and size
  let { name: fileName } = file;
  fileName = fileName.replaceAll("\n", "");
  document.querySelector(".file-name").textContent = `${fileName}`;
});

const closeForm = () => {
  createForm.classList.add("hidden");
  overlay.classList.add("hidden");
  contentBody.classList.remove("max-height-form");
};

createBtn.addEventListener("click", () => {
  createForm.classList.remove("hidden");
  overlay.classList.remove("hidden");
  contentBody.classList.add("max-height-form");
});

closeBtn.addEventListener("click", closeForm);
overlay.addEventListener("click", closeForm);
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape" && !createForm.classList.contains("hidden")) {
    closeForm();
  }
});
