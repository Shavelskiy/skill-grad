const axios = require('axios').default;

import './index.scss';
import {showAlert, showModalFormError, hideModalFormError} from './../modal/index';
import {load} from 'recaptcha-v3';

/* modals */
const loginModal = document.getElementById('login-modal');
const resetPasswordModal = document.getElementById('forgot-password-modal');
const newPasswordModal = document.getElementById('new-password-modal');
const registerRoleModal = document.getElementById('register-role-modal');
const registerModal = document.getElementById('register-modal');

/* кнопки, вызывающие попапы и открытие их */
const showModal = function (modal) {
  modal.classList.add('modal-active');
}

/* кнопки в хедере */
document.getElementById('login-modal-button').onclick = () => showModal(loginModal);
document.getElementById('register-modal-button').onclick = () => showModal(registerRoleModal);

/* кнопки в попапе авторизации */
loginModal.querySelector('.login-forgot-password-link').onclick = () => {
  showModal(resetPasswordModal);
  loginModal.classList.remove('modal-active');
}
loginModal.querySelector('.login-register-link').onclick = () => {
  showModal(registerRoleModal);
  loginModal.classList.remove('modal-active');
}

/* переход с выбора типа аккаунта на форму регистрации */
const registerFormRoleInput = registerModal.querySelector('input[name="role"]')

document.getElementById('register-user-button').onclick = () => {
  showModal(registerModal);
  registerRoleModal.classList.remove('modal-active');
  registerFormRoleInput.value='user';
}
document.getElementById('register-provider-button').onclick = () => {
  showModal(registerModal);
  registerRoleModal.classList.remove('modal-active');
  registerFormRoleInput.value='provider';
}


const initModalForm = function (modal, isNewPasswordModal, recaptchaAction) {
  const form = modal.querySelector('form');
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
      recaptcha.hideBadge();
      recaptcha.execute(recaptchaAction).then((token) => {
        formData.append('g_recaptcha_response', token);

        axios.post(form.action, formData)
          .then(response => {
            modal.classList.remove('modal-active');
            showAlert(response.data);
          })
          .catch(error => {
            if (!isNewPasswordModal) {
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
    case registerRoleModal:
      registerRoleModal.classList.remove('modal-active');
      break;
    case registerModal:
      registerModal.classList.remove('modal-active');
      break;
  }
}
