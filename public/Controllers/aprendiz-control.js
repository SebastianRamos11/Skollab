// Navbar functions
const ham = document.querySelector(".ham");
const links = document.querySelector(".nav-menu");
const bars = document.querySelectorAll(".ham span");

ham.addEventListener("click", () => {
  links.classList.toggle("nav-menu--active");
  ham.classList.toggle("opened");
  ham.setAttribute("aria-expanded", ham.classList.contains("opened"));
});

const course = document.querySelectorAll(".course");
const courseActivities = document.querySelectorAll(".activities-course");
const activity = document.querySelectorAll(".activity");
const courseTitle = document.querySelectorAll(".course__title");

const generateAcronym = function (e) {
  let acronym = "";
  for (const word of e.split(" ")) {
    if (word.length <= 2) continue;
    acronym += word[0];
  }
  return acronym;
};

for (let i = 0; i < course.length; i++) {
  if (courseTitle[i].textContent.split(" ").length >= 4)
    courseTitle[i].textContent = generateAcronym(courseTitle[i].textContent);
}

// ----------

course.forEach((e, i) => {
  course[i].addEventListener("click", () => {
    document.querySelector(`.activities`).classList.remove("hidden");
    courseActivities[i].classList.remove("hidden");

    for (let j = 0; j < courseActivities.length; j++) {
      if (courseActivities[j] === courseActivities[i]) continue;
      courseActivities[j].classList.add("hidden");
    }
  });
});

// FILE SELECTION
const file = document.querySelector("#file");
if (file) {
  file.addEventListener("change", (e) => {
    console.log("I'm here!");
    // Get the selected file
    const [file] = e.target.files;
    // Get the file name and size
    let { name: fileName } = file;
    fileName = fileName.replaceAll("\n", "");
    document.querySelector(".file-icon").classList.remove("hidden");
    document.querySelector(".file-selected-name").textContent = `${fileName}`;
  });
}
