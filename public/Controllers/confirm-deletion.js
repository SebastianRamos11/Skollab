const confirmDeletion = (title) => {
  const deleteElement = document.querySelectorAll(".delete-button");
  deleteElement.forEach((e, i) => {
    deleteElement[i].addEventListener("click", (e) => {
      e.preventDefault();
      console.log(deleteElement[i].getAttribute("href"));
      Swal.fire({
        title,
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.assign(deleteElement[i].getAttribute("href"));
        }
      });
    });
  });
};
