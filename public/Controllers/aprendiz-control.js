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
const coursePublications = document.querySelectorAll(".publications-course");
const publication = document.querySelectorAll("publication");
const courseTitle = document.querySelectorAll(".course__title");
const fileName = document.querySelectorAll(".file-name");

// Normalizing texts

fileName.forEach((e, i) => {
  fileName[i].textContent = fileName[i].textContent
    .replace("../file-store/", "")
    .replace("publications/", "");
});

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
    document.querySelector(`.evidences`).classList.remove("hidden");
    coursePublications[i].classList.remove("hidden");

    for (let j = 0; j < coursePublications.length; j++) {
      if (coursePublications[j] === coursePublications[i]) continue;
      coursePublications[j].classList.add("hidden");
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
