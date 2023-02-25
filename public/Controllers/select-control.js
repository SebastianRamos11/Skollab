$(".subject-selection").select2({
  placeholder: "Selecciona una materia",
  language: {
    noResults: function () {
      return "No se encontró la materia especificada";
    },
  },
});

$(".subject-selection").on("select2:open", function (e) {
  document.querySelector(".select2-search__field").focus();
  document
    .querySelector(".select2-search__field")
    .setAttribute("placeholder", "Escribe aqui...");
});

$(".instructor-selection").select2({
  placeholder: "Selecciona un instructor",
  language: {
    noResults: function () {
      return "No se encontró el instructor especificado";
    },
  },
});

$(".instructor-selection").on("select2:open", function (e) {
  document.querySelector(".select2-search__field").focus();
  document
    .querySelector(".select2-search__field")
    .setAttribute("placeholder", "Escribe aqui...");
});
