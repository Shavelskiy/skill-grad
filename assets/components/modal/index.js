import './choose-role-modal'
import './city-selector'
import './alert'

export const loginModal = document.getElementById('login-modal')
export const resetPasswordModal = document.getElementById('forgot-password-modal')
export const registerRoleModal = document.getElementById('register-role-modal')
export const registerModal = document.getElementById('register-modal')
export const newPasswordModal = document.getElementById('new-password-modal')
export const citySelectorModal = document.getElementById('city-selector-modal')
export const feedbackModal = document.getElementById('feedback-modal')

export const initModal = (modal) => {
  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      modal.classList.remove('active')
    }
  })

  const closeButton = modal.querySelector('span.close')

  if (closeButton !== null) {
    closeButton.onclick = () => {
      modal.classList.remove('active')
    }
  }
}

export const initRelationModal = (modal, selector, openModal) => {
  modal.querySelector(selector).onclick = () => {
    modal.classList.remove('active')
    openModal.classList.add('active')
  }
}

initModal(loginModal)
initModal(resetPasswordModal)
initModal(registerRoleModal)
initModal(registerModal)
initModal(newPasswordModal)
initModal(citySelectorModal)
initModal(feedbackModal)
