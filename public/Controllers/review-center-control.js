"use strict";

// ELEMENTS

// Group selector
const groupSelector = document.querySelector(".nav-group__select");
// const group = document.querySelectorAll('.ficha'); // Arr (¿Unnessesary?)
const groupSelectorBtn = document.querySelector(".nav-group__btn");

// Activities
const groupActivities = document.querySelectorAll(".activities-course"); // Arr
const activityBtn = document.querySelectorAll(".activity-btn"); // Arr FIXME

// Evidences
const groupEvidences = document.querySelectorAll(".evidences-course"); // Arr
const activityEvidences = document.querySelectorAll(".evidences-activity"); // Arr
const evidence = document.querySelectorAll(".evidence"); // Arr

// Display element
const displayElements = function (element, active) {
  element[active].classList.remove("hidden");
  clearRestElements(element, active);
};

// Delete display to activities no selected
const clearRestElements = function (element, active) {
  for (let i = 0; i < element.length; i++) {
    if (element[i] === element[active]) continue;
    element[i].classList.add("hidden");
  }
};

// Event Listener to Group Selector
groupSelectorBtn.addEventListener("click", () => {
  const groupSelected = groupSelector.value;
  displayElements(groupActivities, groupSelected);
  for (let i = 0; i < activityEvidences.length; i++) {
    activityEvidences[i].classList.add("hidden");
  }
});

// Event Listener to Activity Selector
activityBtn.forEach((e, i) => {
  activityBtn[i].addEventListener("click", (e) => {
    console.log(e.target.id);
    document
      .querySelector(`.evidences-${e.target.id}`)
      .classList.remove("hidden");
    for (let i = 0; i < activityEvidences.length; i++) {
      if (activityEvidences[i].classList.contains(`evidences-${e.target.id}`))
        continue;
      activityEvidences[i].classList.add("hidden");
    }
  });
});
