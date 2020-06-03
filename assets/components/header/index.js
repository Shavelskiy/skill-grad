import { loginModal, resetPasswordModal, registerRoleModal, citySelectorModal, feedbackModal } from '../modal'
import './logout'
import './index.scss'

const openLoginModalBtn = document.querySelector('.open-login-modal-btn')
const openRegisterModalBtn = document.querySelector('.open-register-modal-btn')
const openCitySelectorModalBtn = document.querySelector('.open-city-selector-modal-btn')

if (openLoginModalBtn !== null) {
  openLoginModalBtn.onclick = () => {
    loginModal.classList.add('is-visible')
  }
}

if (openRegisterModalBtn !== null) {
  openRegisterModalBtn.onclick = () => {
    registerRoleModal.classList.add('is-visible')
  }
}

openCitySelectorModalBtn.onclick = () => {
  citySelectorModal.classList.add('is-visible')
}

loginModal.querySelector('.login-forgot-password-link').onclick = () => {
  resetPasswordModal.classList.add('is-visible')
  loginModal.classList.remove('is-visible')
}

loginModal.querySelector('.login-register-link').onclick = () => {
  registerRoleModal.classList.add('is-visible')
  loginModal.classList.remove('is-visible')
}

citySelectorModal.querySelector('.open-feedback-modal-btn').onclick = () => {
  feedbackModal.classList.add('is-visible')
  citySelectorModal.classList.remove('is-visible')
}
