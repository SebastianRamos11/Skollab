const file = document.querySelector('#file');

file.addEventListener('change', e => {
  // Get the selected file
  const [file] = e.target.files;
  // Get the file name and size
  let { name: fileName } = file;
  fileName = fileName.replaceAll('\n', '');
  document.querySelector('.file-name').textContent = `${fileName}`;
});
