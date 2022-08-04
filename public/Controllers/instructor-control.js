const ham = document.querySelector('.ham');
const links = document.querySelector('.nav-menu');
const bars = document.querySelectorAll('.ham span');

ham.addEventListener('click', () => {
  links.classList.toggle('nav-menu--active');
  ham.classList.toggle('opened');
  ham.setAttribute('aria-expanded', ham.classList.contains('opened'));
});

const group = document.querySelector(".group");
const btnGroup = document.querySelector(".id-group-btn");

btnGroup.addEventListener('click', () => {
  group.classList.toggle('hidden');
});

const generateAcronym = function(e) {
  let acronym = '';
  for(const word of e.join(' ')){
    acronym += word[0];
  }
  return acronym;
}

btnGroup.textContent = generateAcronym(btnGroup.textContent);

