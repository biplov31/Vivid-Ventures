const eventInfo = document.querySelector('.event-info');
window.onload = () => {
  eventInfo.style.top = "95%";
}

const nameField = document.getElementById('name');
const mobileNumberField = document.getElementById('contact');
const emailField = document.getElementById('email');

const registerBtn = document.querySelector('.register-btn');
const formOverlay = document.querySelector('.form-overlay')
registerBtn.addEventListener('click' , async () => {
  userId = registerBtn.value;
  if (userId == '') {
    window.location.href = 'http://localhost/vivid-ventures/views/login.php';
    return;
  }

  formOverlay.style.display = 'grid';
 
  const response = await fetch(`http://localhost/vivid-ventures/controllers/packageRegistration.php?user_id=${userId}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    },
  })
  if (response.ok) {
    const data = await response.json();
    nameField.value = data['name'];
    mobileNumberField.value = data['mobile_number'];
    emailField.value = data['email'];
  }
})

const cancelBtn = document.querySelector('.cancel-btn');
cancelBtn.addEventListener('click', () => {
  formOverlay.style.display = 'none';
})

const confirmRegisterBtn = document.querySelector('.confirm-register-btn');
// confirmRegisterBtn.addEventListener('click', registerEvent);

// async function registerEvent(e) {
//   e.preventDefault();
  
// }