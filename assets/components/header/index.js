import {loginModal, resetPasswordModal, registerRoleModal, citySelectorModal, feedbackModal} from '../modal'
import './logout'
import './category-menu'
import './dropdown'


const openLoginModalButtons = document.querySelectorAll('.open-login-modal-btn')
const openRegisterModalBtn = document.querySelector('.open-register-modal-btn')
const openCitySelectorModalButtons = document.querySelectorAll('.open-city-selector-modal-btn')

const favoriteCount = document.querySelector('.user-favorite-count')
const compareCount = document.querySelector('.compare-count')

if (openLoginModalButtons.length > 0) {
  openLoginModalButtons.forEach((item) => {
    item.onclick = () => {
      loginModal.classList.add('active')
    }
  })
}

if (openRegisterModalBtn !== null) {
  openRegisterModalBtn.onclick = () => {
    registerRoleModal.classList.add('active')
  }
}

openCitySelectorModalButtons.forEach((item) => {
  item.onclick = () => {
    citySelectorModal.classList.add('active')
  }
})


loginModal.querySelector('.login-forgot-password-link').onclick = () => {
  resetPasswordModal.classList.add('active')
  loginModal.classList.remove('active')
}

loginModal.querySelector('.login-register-link').onclick = () => {
  registerRoleModal.classList.add('active')
  loginModal.classList.remove('active')
}

citySelectorModal.querySelector('.open-feedback-modal-btn').onclick = () => {
  feedbackModal.classList.add('active')
  citySelectorModal.classList.remove('active')
}

export const updateFavoriteCount = (value) => {
  if (favoriteCount) {
    favoriteCount.innerHTML = Number(favoriteCount.innerHTML) + value
  }
}

export const updateCompareCount = (value) => {
  if (compareCount) {
    compareCount.innerHTML = value
  }
}
