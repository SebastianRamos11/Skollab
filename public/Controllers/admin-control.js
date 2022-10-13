"use strict";

// MODALS (FORMS)
const modalCreateUser = document.querySelector(".modal-container");
const modalCreateAd = document.querySelector(".modal-announcement");

// MODAL CONTROLS
const btnOpenModal = document.querySelector(".open-modal");
const btnCloseModal = document.querySelector(".close-modal");
const overlay = document.querySelector(".overlay");
const body = document.querySelector("body");

const openModal = function (modal) {
  modal.classList.remove("hidden");
  overlay.classList.remove("hidden");
  body.classList.add("overflow-hidden");
};
const closeModal = function (modal) {
  modal.classList.add("hidden");
  overlay.classList.add("hidden");
  body.classList.remove("overflow-hidden");
};

if (modalCreateUser) {
  btnOpenModal.addEventListener("click", () => openModal(modalCreateUser));
  btnCloseModal.addEventListener("click", () => closeModal(modalCreateUser));
  overlay.addEventListener("click", () => closeModal(modalCreateUser));
}

// TODO: ANNOUNCEMENTS
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
