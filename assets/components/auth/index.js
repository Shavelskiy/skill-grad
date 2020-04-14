const axios = require('axios').default;

import './index.scss';
import {showAlert, showModalFormError, hideModalFormError} from './../modal/index';

/* modals */
const loginModal = document.getElementById('login-modal');
const resetPasswordModal = document.getElementById('forgot-password-modal');
const newPasswordModal = document.getElementById('new-password-modal');

/* кнопки, вызывающие попапы и открытие их */
const loginModalBtn = document.getElementById('login-modal-button');
const resetPasswordBtn = loginModal.querySelector('.login-forgot-password-link');

loginModalBtn.onclick = function () {
  loginModal.classList.add('modal-active');
};

resetPasswordBtn.onclick = function () {
  loginModal.classList.remove('modal-active');
  resetPasswordModal.classList.add('modal-active');
};

const initModalForm = function (modal, isNewPasswordModal) {
  const form = modal.querySelector('form');
  const csrfInput = form.querySelector('input[name="_csrf_token"]');
  const formButton = form.querySelector('button');

  form.onsubmit = function (e) {
    e.preventDefault();

    if (isNewPasswordModal) {
      const passwordInput = form.querySelector('input[name="password"]');
      const confirmPasswordInput = form.querySelector('input[name="confirm-password"]');

      if (passwordInput.value !== confirmPasswordInput.value) {
        showModalFormError(form, 'Пароли должны совпадать');
        return;
      }
    }

    formButton.disabled = true;
    hideModalFormError(form);

    axios.post(form.action, new FormData(this))
      .then(response => {
        modal.classList.remove('modal-active');
        showAlert(response.data);
      })
      .catch(error => {
        if (!isNewPasswordModal) {
          csrfInput.value = error.response.data.csrf;
          formButton.disabled = false;
        }
        showModalFormError(form, error.response.data.message);
      });
  }
}

initModalForm(loginModal, false);
initModalForm(resetPasswordModal, false);
initModalForm(newPasswordModal, true)

/* закрытие попапов */
window.onclick = function (event) {
  switch (event.target) {
    case loginModal:
      loginModal.classList.remove('modal-active');
      break;
    case resetPasswordModal:
      resetPasswordModal.classList.remove('modal-active');
      break;
    case newPasswordModal:
      newPasswordModal.classList.remove('modal-active');
      break;
  }
}
