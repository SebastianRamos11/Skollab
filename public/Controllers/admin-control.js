"use strict";

// MODAL (FORM)

const modal = document.querySelector(".modal-container");
const btnCloseModal = document.querySelector(".close-modal");
const overlay = document.querySelector(".overlay");
const btnOpenModal = document.querySelector(".create-button");
const body = document.querySelector("body");

const openModal = function () {
  modal.classList.remove("hidden");
  overlay.classList.remove("hidden");
  body.classList.add("overflow-hidden");
};
const closeModal = function () {
  modal.classList.add("hidden");
  overlay.classList.add("hidden");
  body.classList.remove("overflow-hidden");
};

if (btnOpenModal) {
  btnOpenModal.addEventListener("click", openModal);
  btnCloseModal.addEventListener("click", closeModal);
  overlay.addEventListener("click", closeModal);
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

// TODO: ANNOUNCEMENTS

const createAdBtn = document.querySelector(".create-ad");
if (createAdBtn) {
  createAdBtn.addEventListener("click", () => console.log("I'm here!"));
}
