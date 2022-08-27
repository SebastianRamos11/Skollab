const passField = document.querySelectorAll('.pass-input');
const seeBtn = document.querySelectorAll('.see-btn');
const unSeeBtn = document.querySelectorAll('.unsee-btn');

unSeeBtn.forEach(function (e, i) {
  unSeeBtn[i].addEventListener('click', function () {
    unSeeBtn[i].style.display = 'none';
    seeBtn[i].style.display = 'block';
    passField[i].type = 'text';
  });
});

seeBtn.forEach(function (e, i) {
  seeBtn[i].addEventListener('click', function () {
    unSeeBtn[i].style.display = 'block';
    seeBtn[i].style.display = 'none';
    passField[i].type = 'password';
  });
});
