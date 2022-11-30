const file = document.querySelectorAll(".file");
file.forEach((input, i) => {
  input.addEventListener("change", (e) => {
    if (e.target.files.length > 0) {
      const [file] = e.target.files;
      let { name: fileName } = file;
      fileName = fileName.replaceAll("\n", "");
      document.querySelectorAll(".uploaded-file")[
        i
      ].textContent = `${fileName}`;
    }
  });
});
