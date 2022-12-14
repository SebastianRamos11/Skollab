const filterInput = document.getElementById("filterInput");

const filterNames = () => {
  let filterValue = document.getElementById("filterInput").value.toLowerCase();
  let subjectName = document.querySelectorAll(".course-subject");

  // Loop through subjects names
  for (let i = 0; i < subjectName.length; i++) {
    let span = subjectName[i].getElementsByClassName("subject-name")[0];
    if (span.innerHTML.toLowerCase().includes(filterValue)) {
      subjectName[i].style.display = "";
    } else {
      subjectName[i].style.display = "none";
    }
  }
};

filterInput.addEventListener("keyup", filterNames);
