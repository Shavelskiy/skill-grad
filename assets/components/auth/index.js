const axios = require('axios').default;

import './index.scss';

const loginModal = document.getElementById('login-modal');
const loginModalBtn = document.getElementById('login-modal-button');

const forgotPasswordModal = document.getElementById('forgot-password-modal');
const forgotPasswordBtn = loginModal.querySelector('.login-forgot-password-link');

loginModalBtn.onclick = function () {
  loginModal.classList.add('modal-active');
};

forgotPasswordBtn.onclick = function () {
  loginModal.classList.remove('modal-active');
  forgotPasswordModal.classList.add('modal-active');
};

window.onclick = function (event) {
  switch (event.target) {
    case loginModal:
      loginModal.classList.remove('modal-active');
      break;
    case forgotPasswordModal:
      forgotPasswordModal.classList.remove('modal-active');
      break;
  }
}

const loginForm = loginModal.querySelector('form');
const loginCsrfInput = loginForm.querySelector('input[name="_csrf_token"]');
const loginButton = loginForm.querySelector('button');

loginForm.onsubmit = function (e) {
  e.preventDefault();
  loginButton.disabled = true;

  axios.post('/ajax/login', new FormData(this))
    .then(response => {
      loginModal.classList.remove('modal-active');
      loginButton.disabled = false;
    })
    .catch(error => {
      loginCsrfInput.value = error.response.data.csrf;
      loginButton.disabled = false;
    });
}

