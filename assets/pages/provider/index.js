import { loginModal, registerRoleModal, initModalFormCloseBtn } from '../../components/modal'

import { addProviderToFavorite } from '../../components/common/favorite'
import {isAuth} from '../../helpers/auth'

const addFavoritesModal = document.getElementById('add-favorites-modal')
const sendMessageModal = document.getElementById('send-message-modal')

window.addEventListener('click', (event) => {
  switch (event.target) {
    case addFavoritesModal:
      addFavoritesModal.classList.remove('active')
      break
    case sendMessageModal:
      sendMessageModal.classList.remove('active')
      break
  }
})

const initModals = (modal, selector, openModal) => {
  modal.querySelector(selector).onclick = () => {
    modal.classList.remove('active')
    openModal.classList.add('active')
  }
}

initModals(addFavoritesModal, '.login-btn', loginModal)
initModals(addFavoritesModal, '.register-btn', registerRoleModal)
initModals(sendMessageModal, '.login-btn', loginModal)
initModals(sendMessageModal, '.register-btn', registerRoleModal)

initModalFormCloseBtn(addFavoritesModal)
initModalFormCloseBtn(sendMessageModal)

document.querySelectorAll('.send-email').forEach(item => {
  item.onclick = () => {
    if (!isAuth()) {
      sendMessageModal.classList.add('active')
    }
  }
})

document.querySelectorAll('.add-provider-favorites').forEach(item => {
  item.onclick = () => {
    if (!isAuth()) {
      addFavoritesModal.classList.add('active')
    } else {
      addProviderToFavorite(item)
    }
  }
})
