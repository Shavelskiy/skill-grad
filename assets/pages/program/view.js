import {loginModal, registerRoleModal, initModalFormCloseBtn} from '../../components/modal'

import {addProgramToFavorite} from '../../components/common/favorite'

const addFavoritesModal = document.getElementById('add-favorites-modal')

window.addEventListener('click', (event) => {
  if (event.target === addFavoritesModal) {
    addFavoritesModal.classList.remove('active')
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

initModalFormCloseBtn(addFavoritesModal)

document.querySelectorAll('.add-program-favorites').forEach(item => {
  item.onclick = () => {
    if (document.body.dataset.auth === 'false') {
      addFavoritesModal.classList.add('active')
    } else {
      addProgramToFavorite(item)
    }
  }
})
