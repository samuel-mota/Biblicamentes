//******************
// ASIDE MENU NAVIGATION
//******************
const capitulosBtn = document.querySelector('.capitulos-btn');
const modalAside = document.querySelector('.js-modal-aside');

capitulosBtn.addEventListener('click', () => {
  modalAside.classList.toggle('nav-bible-slide-in');
  modalAside.classList.toggle('is-modal');

  modalBgToggle();
});


