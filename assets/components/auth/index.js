const axios = require('axios').default;

import './index.scss';

const authModal = document.getElementById('auth-modal');
const authModalBtn = document.getElementById('auth-modal-button');

if ((authModalBtn !== null) && (authModal !== null)) {
  authModalBtn.onclick = function () {
    authModal.classList.add('modal-active');
  };

  window.onclick = function (event) {
    if (event.target === authModal) {
      authModal.classList.remove('modal-active');
    }
  }

  const authForm = authModal.querySelector('form');
  const loginCsrfInput = authForm.querySelector('input[name="_csrf_token"]');
  const authButton = authForm.querySelector('button');

  authForm.onsubmit = function (e) {
    e.preventDefault();
    authButton.disabled = true;

    axios.post('/ajax/login', new FormData(this))
      .then(response => {
        authModal.classList.remove('modal-active');
        authButton.disabled = false;
      })
      .catch(error => {
        loginCsrfInput.value = error.response.data.csrf;
        authButton.disabled = false;
      });
  }
}
