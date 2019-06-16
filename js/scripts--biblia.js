//******************
// ASIDE MENU NAVIGATION
//******************
const capitulosBtn = document.querySelector('.js-aside-button');
const modalAside = document.querySelector('.js-aside-modal');

capitulosBtn.addEventListener('click', () => {
  modalAside.classList.toggle('is-aside-nav--open');
  modalAside.classList.toggle('is-modal');

  modalBgToggle();
});


