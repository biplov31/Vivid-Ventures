const emailField = document.querySelector('input[type=email]');
const emailError = document.querySelector('.email-error');
const passwordField = document.querySelector('input[type=password]');
const passwordError = document.querySelector('.password-error');
const loginBtn = document.querySelector('button[name="login"]');

// const displayError = (inputField, errorMsg) => {
//   if (!inputField.value) return;
//   const existingError = inputField.nextElementSibling;
//   if (existingError && existingError.classList.contains('form-error')) {
//     existingError.textContent = errorMsg;
//   } else {
//     let newError = document.createElement('span');
//     newError.setAttribute('class', 'form-error');
//     newError.textContent = errorMsg;
//     inputField.insertAdjacentElement('afterend', newError);
//   }
// }

// const removeExistingError = (inputField) => {
//   const existingError = inputField.nextElementSibling;
//   if (existingError && existingError.classList.contains('form-error')) {
//     inputField.nextElementSibling.remove();
//   }
// }

// const inputFields = document.getElementsByTagName('input');
// Array.from(inputFields).forEach(field => {
//   field.addEventListener('focus', () => {
//     loginBtn.disabled = false;
//   })
// })

// const checkEmailExistence = async (email) => {
//   const response = await fetch(`http://localhost/vivid-ventures/controllers/login.php?email=${email}`, {
//     method: "GET",
//     headers: {
//       "Content-Type": "application/json",
//     }  
//   });
//   if (!response.ok) {
//     displayError(emailField, "Email not found. Please sign up first.");
//     signupBtn.disabled = true;
//     return true;
//   } else {
//     return false;
//   }
// }

// loginBtn.addEventListener('click', async (e) => {
//   let emailExists = await checkEmailExistence(emailField.value);
//   if (emailExists) {
//     e.preventDefault();
//     return;
//   }  
//   document.querySelector('.signup-form').submit();
// }) 

