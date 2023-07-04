const popup = document.querySelector('.popup');
const observer = new IntersectionObserver((entries) => {
  if (entries[0].isIntersecting) {
    setTimeout(() => {
      popup.style.display = 'none';
    }, 4000)
  }
})

if (popup) observer.observe(popup);



