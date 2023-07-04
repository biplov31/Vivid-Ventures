let video = document.querySelector('video')
if (video) video.playbackRate = 0.7

const nav = document.querySelector('.navbar');
const navToggle = document.querySelector('.mobile-nav-toggle');

window.addEventListener('resize', () => {
  if (window.innerWidth > 590) {
    nav.style.transform = 'none';
    nav.style.display = 'block';
  }
})

navToggle.addEventListener('click', () => {
  navToggle.classList.toggle('nav-active');

  if (navToggle.classList.contains('nav-active')) {
    nav.style.transform = 'translateX(0%)';
    nav.style.display = 'block';
  } else {
    nav.style.transform = 'translateX(100%)';
    nav.style.display = 'none';
    // document.body.style.overflow = 'hidden';
  }
})




