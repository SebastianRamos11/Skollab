const group = document.querySelectorAll('.group');
const course = document.querySelectorAll('.course');
const courseTitle = document.querySelectorAll('.course__title');

const generateAcronym = function (e) {
  let acronym = '';
  for (const word of e.split(' ')) {
    if (word.length <= 2) continue;
    acronym += word[0];
  }
  return acronym;
};

for (let i = 0; i < course.length; i++) {
  if (courseTitle[i].textContent.split(' ').length >= 4) courseTitle[i].textContent = generateAcronym(courseTitle[i].textContent);
  group[i].classList.add(`group${i}`);
  course[i].addEventListener('click', () => {
    group[i].classList.remove('hidden');
    for (let j = 0; j < course.length; j++) {
      if (group[j] === group[i]) continue;
      group[j].classList.add('hidden');
    }
  });
}
