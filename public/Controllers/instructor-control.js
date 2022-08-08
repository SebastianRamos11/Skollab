const ham = document.querySelector('.ham');
const links = document.querySelector('.nav-menu');
const bars = document.querySelectorAll('.ham span');

ham.addEventListener('click', () => {
  links.classList.toggle('nav-menu--active');
  ham.classList.toggle('opened');
  ham.setAttribute('aria-expanded', ham.classList.contains('opened'));
});

const group = document.querySelector('.group');
const course = document.querySelector('.course');
const courseTitle = document.querySelector('.course__title');

course.addEventListener('click', () => {
  group.classList.toggle('hidden');
});

const generateAcronym = function (e) {
  let acronym = '';
  for (const word of e.split(' ')) {
    if (word.length <= 2) continue;
    acronym += word[0];
  }
  return acronym;
};

if (courseTitle.textContent.split(' ').length >= 4) courseTitle.textContent = generateAcronym(courseTitle.textContent);
