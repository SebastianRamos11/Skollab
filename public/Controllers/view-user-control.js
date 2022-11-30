const unlinkUser = document.querySelectorAll(".course__unlink");
const deleteEvidence = document.querySelectorAll(
  ".evidence-management__btn-delete"
);
const deleteActivity = document.querySelectorAll(".activity__btn-delete");

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
