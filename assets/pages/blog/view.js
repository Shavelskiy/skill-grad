import './view.scss'

import {loginModal, registerRoleModal, initModalFormCloseBtn} from '@/components/modal'
import {addArticleToFavorite} from '@/components/common/favorite'
import {isAuth} from '@/helpers/auth'


const addFavoritesModal = document.getElementById('add-favorites-modal')

window.addEventListener('click', (event) => {
  switch (event.target) {
    case addFavoritesModal:
      addFavoritesModal.classList.remove('active')
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

initModalFormCloseBtn(addFavoritesModal)

document.querySelectorAll('.add-article-favorites').forEach(item => {
  item.onclick = () => {
    if (!isAuth()) {
      addFavoritesModal.classList.add('active')
    } else {
      addArticleToFavorite(item)
    }
  }
})
