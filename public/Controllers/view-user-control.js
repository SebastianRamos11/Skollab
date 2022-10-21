// TODO: Fix Course Acronym function

// Course Acronym
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

// TODO: Confirm poput to unlink userity

const unlinkUser = document.querySelectorAll(".course__unlink");
const deleteEvidence = document.querySelectorAll(
  ".evidence-management__btn-delete"
);
const deleteActivity = document.querySelectorAll(".activity__btn-delete");
console.log(deleteActivity);

const confirmAction = function (elem, i, subject) {
  Swal.fire({
    title: subject,
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.assign(elem[i].getAttribute("href"));
    }
  });
};

unlinkUser.forEach((e, i) => {
  unlinkUser[i].addEventListener("click", (e) => {
    e.preventDefault();
    confirmAction(
      unlinkUser,
      i,
      "¿Seguro que quieres desvincular a este usuario de este programa?"
    );
  });
});

deleteEvidence.forEach((e, i) => {
  deleteEvidence[i].addEventListener("click", (e) => {
    e.preventDefault();
    confirmAction(
      deleteEvidence,
      i,
      "¿Seguro que quieres desvincular a este usuario de este programa?"
    );
  });
});

deleteActivity.forEach((e, i) => {
  deleteActivity[i].addEventListener("click", (e) => {
    e.preventDefault();
    confirmAction(
      deleteActivity,
      i,
      "¿Seguro que quieres eliminar esta publicación y todos los entregables de la misma?"
    );
  });
});
