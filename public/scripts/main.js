let video = document.querySelector('video');
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


// Guide active status toggle

const statusText = document.querySelector('.active-status-text');
const activeStatusToggle = document.getElementById('active-toggle');
activeStatusToggle?.addEventListener('change', async () => { // with optional chaining, if activeStatusToggle is null or undefined, the event listener will not be added, and no error will occur. This can be particularly useful when dealing with dynamic UI elements that may or may not be present on the page.
  const guideId = document.getElementById('guide-id').value;
  const active = activeStatusToggle.checked === true ? true : false;
  const response = await fetch('http://localhost/vivid-ventures/controllers/guideStatus.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      active,
      guideId
    })
  })
  const guideStatus = await response.json();
  if (response.ok) {
    statusText.textContent = guideStatus.status; 
  }
 
})





