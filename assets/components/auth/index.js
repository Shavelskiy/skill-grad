const axios = require('axios').default;

import './index.scss';
import {showAlert, showModalFormError, hideModalFormError} from './../modal/index';
import {load} from 'recaptcha-v3';

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

const initModalForm = function (modal, isNewPasswordModal, recaptchaAction) {
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

    const formData = new FormData(this);

    load(process.env.RECAPTCHA_SITE_KEY).then((recaptcha) => {
      recaptcha.execute(recaptchaAction).then((token) => {
        formData.append('g_recaptcha_response', token);

        axios.post(form.action, formData)
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
      })
    });
  }
}

initModalForm(loginModal, false, 'login');
initModalForm(resetPasswordModal, false, 'reset-password');
initModalForm(newPasswordModal, true, 'new-password')

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
