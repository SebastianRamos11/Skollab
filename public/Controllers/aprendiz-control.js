const ham = document.querySelector('.ham');
const links = document.querySelector('.nav-menu');
const bars = document.querySelectorAll('.ham span');

ham.addEventListener('click', () => {
  links.classList.toggle('nav-menu--active');
  ham.classList.toggle('opened');
  ham.setAttribute('aria-expanded', ham.classList.contains('opened'));
});
