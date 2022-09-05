'use strict';

// ELEMENTS

// Group selector
const groupSelector = document.querySelector('.nav-group__select');
// const group = document.querySelectorAll('.ficha'); // Arr (¿Unnessesary?)
const groupSelectorBtn = document.querySelector('.nav-group__btn');

// Publications
const groupPublications = document.querySelectorAll('.publications-course'); // Arr
const publicationBtn = document.querySelectorAll('.publication-btn'); // Arr FIXME

// Evidences
const groupEvidences = document.querySelectorAll('.evidences-course'); // Arr
const publicationEvidences = document.querySelectorAll('.evidences-publication'); // Arr
const evidence = document.querySelectorAll('.evidence'); // Arr

// Display element
const displayElements = function (element, active) {
  element[active].classList.remove('hidden');
  clearRestElements(element, active);
};

// Delete display to publications no selected
const clearRestElements = function (element, active) {
  for (let i = 0; i < element.length; i++) {
    if (element[i] === element[active]) continue;
    element[i].classList.add('hidden');
  }
};

// Event Listener to Group Selector
groupSelectorBtn.addEventListener('click', () => {
  const groupSelected = groupSelector.value;
  displayElements(groupPublications, groupSelected);
  for (let i = 0; i < publicationEvidences.length; i++) {
    publicationEvidences[i].classList.add('hidden');
  }
});

// Event Listener to Publication Selector
publicationBtn.forEach((e, i) => {
  publicationBtn[i].addEventListener('click', e => {
    console.log(e.target.id);
    document.querySelector(`.evidences-${e.target.id}`).classList.remove('hidden');
    for (let i = 0; i < publicationEvidences.length; i++) {
      if (publicationEvidences[i].classList.contains(`evidences-${e.target.id}`)) continue;
      publicationEvidences[i].classList.add('hidden');
    }
  });
});
