import './choose-role-modal'
import './city-selector'
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
      loginModal.classList.remove('active')
      break
    case resetPasswordModal:
      resetPasswordModal.classList.remove('active')
      break
    case newPasswordModal:
      newPasswordModal.classList.remove('active')
      break
    case registerRoleModal:
      registerRoleModal.classList.remove('active')
      break
    case registerModal:
      registerModal.classList.remove('active')
      break
    case citySelectorModal:
      citySelectorModal.classList.remove('active')
      break
    case feedbackModal:
      feedbackModal.classList.remove('active')
      break
  }
})

export const initModalFormCloseBtn = (modal) => {
  if (modal === null) {
    return
  }

  const closeButton = modal.querySelector('span.close')

  if (closeButton !== null) {
    closeButton.onclick = () => {
      modal.classList.remove('active')
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
