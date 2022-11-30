const courseTitle = document.querySelectorAll(".course__title");

const generateAcronym = function (e) {
  let acronym = "";
  for (const word of e.split(" ")) {
    if (word.length <= 2) continue;
    acronym += word[0];
  }
  return acronym;
};

for (let i = 0; i < courseTitle.length; i++) {
  if (courseTitle[i].textContent.split(" ").length >= 4)
    courseTitle[i].textContent = generateAcronym(courseTitle[i].textContent);
}
