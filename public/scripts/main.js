let video = document.querySelector('video')
if (video) video.playbackRate = 0.7

const nav = document.querySelector('.navbar');
const navToggle = document.querySelector('.mobile-nav-toggle');

navToggle.addEventListener('click', () => {
  navToggle.classList.toggle('nav-active');

  if (window.innerWidth > 590) {
    alert('hello')
  }

  if (navToggle.classList.contains('nav-active')) {
    nav.style.transform = 'translateX(0%)';
    nav.style.display = 'block';
  } else {
    nav.style.transform = 'translateX(100%)';
    nav.style.display = 'none';
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



