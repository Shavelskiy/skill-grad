import './scss/index.scss'
import './choose-role-modal'
import './alert'

export const loginModal = document.getElementById('login-modal')
export const resetPasswordModal = document.getElementById('forgot-password-modal')
export const registerRoleModal = document.getElementById('register-role-modal')
export const registerModal = document.getElementById('register-modal')
export const newPasswordModal = document.getElementById('new-password-modal')
export const citySelectorModal = document.getElementById('city-selector-modal')
export const feedbackModal =  document.getElementById('feedback-modal')

window.addEventListener('click', (event) => {
  switch (event.target) {
    case loginModal:
      loginModal.classList.remove('is-visible')
      break
    case resetPasswordModal:
      resetPasswordModal.classList.remove('is-visible')
      break
    case newPasswordModal:
      newPasswordModal.classList.remove('is-visible')
      break
    case registerRoleModal:
      registerRoleModal.classList.remove('is-visible')
      break
    case registerModal:
      registerModal.classList.remove('is-visible')
      break
    case citySelectorModal:
      citySelectorModal.classList.remove('is-visible')
      break
    case feedbackModal:
      feedbackModal.classList.remove('is-visible')
      break
  }
})

const initModalFormCloseBtn = (modal) => {
  if (modal === null) {
    return
  }

  const closeButton = modal.querySelector('button.close-modal')

  if (closeButton !== null) {
    closeButton.onclick = () => {
      modal.classList.remove('is-visible')
    }
  }
}

initModalFormCloseBtn(loginModal)
initModalFormCloseBtn(resetPasswordModal)
initModalFormCloseBtn(registerRoleModal)
initModalFormCloseBtn(registerModal)
initModalFormCloseBtn(newPasswordModal)
initModalFormCloseBtn(citySelectorModal)
initModalFormCloseBtn(feedbackModal)
