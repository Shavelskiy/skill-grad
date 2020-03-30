const axios = require('axios').default;

import './index.scss';

const authModal = document.getElementById('auth-modal');
const authModalBtn = document.getElementById('auth-modal-button');

if ((authModalBtn !== null) && (authModal !== null)) {
  authModalBtn.onclick = function () {
    authModal.classList.add('active');
  };

  window.onclick = function (event) {
    if (event.target === authModal) {
      authModal.classList.remove('active');
    }
  }

  const authForm = authModal.querySelector('form');
  authForm.onsubmit = function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    axios.post('/ajax/login', formData).then(r => {});
  }
}
