const subject = document.querySelectorAll(".subject");
const briefcase = document.querySelectorAll(".briefcase");

subject.forEach((e, i) => {
  subject[i].addEventListener("click", () => {
    briefcase[i].classList.toggle("hidden");
    subject[i].classList.toggle("active");
    for (let j = 0; j <= briefcase.length; j++) {
      if (briefcase[j] === briefcase[i]) continue;
      briefcase[j].classList.add("hidden");
      subject[j].classList.remove("active");
    }
  });
});
