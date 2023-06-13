const nameField = document.getElementById('name');
const contactField = document.getElementById('contact');
const emailField = document.querySelector('input[type=email]');
const passwordField = document.getElementById('password');
const rePasswordField = document.getElementById('rePassword');
const dateOfBirthField = document.getElementById('date-of-birth');
const signupBtn = document.querySelector('button[name="signup"]');


const validateInput = (input, regex) => {
  if (!input.match(regex)) {
    signupBtn.disabled = true;
    return false;
  } else {
    return true;
  }
}

const displayError = (inputField, errorMsg) => {
  if (!inputField.value) return;
  const existingError = inputField.nextElementSibling;
  if (existingError && existingError.classList.contains('form-error')) {
    existingError.textContent = errorMsg;
  } else {
    let newError = document.createElement('span');
    newError.setAttribute('class', 'form-error');
    newError.textContent = errorMsg;
    inputField.insertAdjacentElement('afterend', newError);
  }
}

const removeExistingError = (inputField) => {
  const existingError = inputField.nextElementSibling;
  if (existingError && existingError.classList.contains('form-error')) {
    inputField.nextElementSibling.remove();
  }
}

const inputFields = document.getElementsByTagName('input');
Array.from(inputFields).forEach(field => {
  field.addEventListener('focus', () => {
    signupBtn.disabled = false;
  })
})

nameField.addEventListener('blur', () => {
  if (!validateInput(nameField.value, /^[A-Za-z\s]+$/)) {
    displayError(nameField, "Name should only contain alphabet characters.");
  } else {
    removeExistingError(nameField);
  }
})

contactField.addEventListener('blur', () => {
  if (!validateInput(contactField.value, /^98\d{8}$/)) {
    displayError(contactField, "Mobile number is not valid.");
  } else {
    removeExistingError(contactField);
  }
})

const checkEmailDuplication = async (email) => {
  const response = await fetch(`http://localhost/vivid-ventures/controllers/signup.php?email=${email}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    }  
  });
  if (!response.ok) {
    displayError(emailField, "Email address already exists.");
    signupBtn.disabled = true;
  }
}

emailField.addEventListener('blur', () => {
  if (!validateInput(emailField.value, /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
    return displayError(emailField, "Email address is not valid.");
  } else {
    removeExistingError(emailField);
  }
  checkEmailDuplication(emailField.value);
})

passwordField.addEventListener('blur', () => {
  // /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/
  if (!validateInput(passwordField.value, /^[A-Za-z0-9]+$/)) {
    displayError(passwordField, "Password must be 8 to 15 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.");
  } else {
    removeExistingError(passwordField);
  }
})

rePasswordField.addEventListener('blur', () => {
  if (passwordField.value !== rePasswordField.value) {
    displayError(rePasswordField, "Passwords do not match.");
    signupBtn.disabled = true;
  } else {
    removeExistingError(rePasswordField);
  }
})

signupBtn.addEventListener('click', () => {

  // let age = (new Date() - dateOfBirthField.value)/(1000*60*60*24*365);
}) 