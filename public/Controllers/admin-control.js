"use strict";

// MODALS (FORMS)
const modalCreateUser = document.querySelector(".modal-container");
const modalCreateAd = document.querySelector(".modal-announcement");

// MODAL CONTROLS
const btnOpenModal = document.querySelector(".open-modal");
const btnCloseModal = document.querySelector(".close-modal");
const overlay = document.querySelector(".overlay");
const body = document.querySelector("body");

// Elements
const fileInput = document.querySelectorAll(".file");
const contentBody = document.querySelector(".main-content");

if (fileInput) {
  fileInput.forEach((file, i) => {
    file.addEventListener("change", (e) => {
      console.log("I'm here bitch!");
      // Get the selected file
      const [file] = e.target.files;
      // Get the file name and size
      let { name: fileName } = file;
      fileName = fileName.replaceAll("\n", "");
      document.querySelectorAll(".file-name")[i].textContent = `${fileName}`;
    });
  });
}

const openModal = function (modal) {
  modal.classList.remove("hidden");
  overlay.classList.remove("hidden");
  contentBody.classList.add("max-height-form");
};

const closeModal = function (modal) {
  modal.classList.add("hidden");
  overlay.classList.add("hidden");
  contentBody.classList.remove("max-height-form");
};

if (modalCreateUser) {
  btnOpenModal.addEventListener("click", () => openModal(modalCreateUser));
  btnCloseModal.addEventListener("click", () => closeModal(modalCreateUser));
  overlay.addEventListener("click", () => closeModal(modalCreateUser));
}

if (modalCreateAd) {
  btnOpenModal.addEventListener("click", () => openModal(modalCreateAd));
  btnCloseModal.addEventListener("click", () => closeModal(modalCreateAd));
  overlay.addEventListener("click", () => closeModal(modalCreateAd));
}

// CRUD

const readButton = document.querySelectorAll(".crud-option__btn");
const roleCrud = document.querySelectorAll(".crud");

if (readButton) {
  readButton.forEach((e, i) => {
    readButton[i].addEventListener("click", () => {
      roleCrud[i].classList.remove("hidden");
      for (let j = 0; j < roleCrud.length; j++) {
        if (roleCrud[j] === roleCrud[i]) continue;
        roleCrud[j].classList.add("hidden");
      }
    });
  });
}
