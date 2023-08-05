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

const registrationForm = document.querySelector('.registration-form');
registrationForm.addEventListener('submit', async (e) => {
  e.preventDefault(); 
  const packageId = document.getElementById('package-id').value;
  const userId = document.getElementById('user-id').value;
  
  const response = await fetch(`http://localhost/vivid-ventures/controllers/packageRegistration.php`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      packageId,
      userId,
      name: nameField.value,
      mobileNumber: mobileNumberField.value,
      email: emailField.value
    })
  })
  const data = await response.json();
  const popup = document.createElement('div');
  popup.classList.add('popup');
  popup.textContent = data.message;
  popup.classList.add(response.ok ? 'success' : 'failure');
  formOverlay.style.display = 'none';
  document.body.appendChild(popup);
  
  setTimeout(() => {
    document.body.removeChild(popup);
  }, 4000)
})
