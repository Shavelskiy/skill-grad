import { loginModal, registerRoleModal, initModal, initRelationModal } from '@/components/modal'

import { addProviderToFavorite } from '@/components/common/favorite'
import { isAuth } from '@/helpers/auth'

const addFavoritesModal = document.getElementById('add-favorites-modal')
const sendMessageModal = document.getElementById('send-message-modal')

initModal(addFavoritesModal)
initModal(sendMessageModal)

initRelationModal(addFavoritesModal, '.login-btn', loginModal)
initRelationModal(addFavoritesModal, '.register-btn', registerRoleModal)
initRelationModal(sendMessageModal, '.login-btn', loginModal)
initRelationModal(sendMessageModal, '.register-btn', registerRoleModal)

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
