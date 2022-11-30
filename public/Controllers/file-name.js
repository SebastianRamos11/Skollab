const fileName = document.querySelectorAll(".file-name");
if (fileName)
  fileName.forEach(
    (elem) =>
      (elem.textContent = elem.textContent.slice(
        elem.textContent.lastIndexOf("/") + 1
      ))
  );
