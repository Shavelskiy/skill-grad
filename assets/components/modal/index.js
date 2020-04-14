import './scss/index.scss';

const alertModal = document.getElementById('alert-modal');
const alertMessage = alertModal.querySelector('.message');

const closeAlert = function () {
  setTimeout(function () {
    alertModal.classList.remove('modal-active');
  }, 1500);
};

closeAlert();

export const showAlert = function (message) {
  alertMessage.textContent = message;
  alertModal.classList.add('modal-active');
  closeAlert();
}

export const showModalFormError = function (form, error) {
  const modalError = form.querySelector('.error');
  modalError.classList.add('error-active');
  modalError.textContent = error;
};

export const hideModalFormError = function (form) {
  const modalError = form.querySelector('.error');
  modalError.classList.remove('error-active');
  modalError.textContent = '';
};