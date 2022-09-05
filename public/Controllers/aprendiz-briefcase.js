'strict mode';

const program = document.querySelectorAll('.program');
const briefcase = document.querySelectorAll('.briefcase');

program.forEach((e, i) => {
  program[i].addEventListener('click', () => {
    briefcase[i].classList.remove('hidden');
  });
});
