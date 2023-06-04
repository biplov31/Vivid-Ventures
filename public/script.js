const nav = document.querySelector('.navbar');
const navToggle = document.querySelector('.mobile-nav-toggle');

navToggle.addEventListener('click', () => {
  navToggle.classList.toggle('nav-active');

  if (navToggle.classList.contains('nav-active')) {
    nav.style.transform = 'translateX(0%)';
  } else {
    nav.style.transform = 'translateX(100%)';
    document.body.style.overflow = 'hidden';
  }
})

const registerBtn = document.querySelector('.confirmation-btn');
const formOverlay = document.querySelector('.form-overlay')
registerBtn.addEventListener('click' , () => {
  formOverlay.style.display = 'grid';
})

const cancelBtn = document.querySelector('.cancel-btn');
cancelBtn.addEventListener('click', () => {
  formOverlay.style.display = 'none';
})

