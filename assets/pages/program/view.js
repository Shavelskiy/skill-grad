import axios from 'axios'
import {loginModal, registerRoleModal, initModalFormCloseBtn} from '../../components/modal'
import {addProgramToFavorite} from '../../components/common/favorite'
import showAlert from '../../components/modal/alert'

import {ADD_PROGRAM_QUESTION} from '../../utils/api-routes'

const addFavoritesModal = document.getElementById('add-favorites-modal')
const questionAuthModal = document.getElementById('question-auth-modal')
const questionModal = document.getElementById('program-question-modal')
const addProgramQuestionButton = questionModal.querySelector('button')

window.addEventListener('click', (event) => {
  switch (event.target) {
    case addFavoritesModal:
      addFavoritesModal.classList.remove('active')
      break
    case questionAuthModal:
      questionAuthModal.classList.remove('active')
      break
    case questionModal:
      questionModal.classList.remove('active')
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
initModals(questionAuthModal, '.login-btn', loginModal)
initModals(questionAuthModal, '.register-btn', registerRoleModal)

initModalFormCloseBtn(addFavoritesModal)
initModalFormCloseBtn(questionAuthModal)
initModalFormCloseBtn(questionModal)

document.querySelectorAll('.add-program-favorites').forEach(item => {
  item.onclick = () => {
    if (document.body.dataset.auth === 'false') {
      addFavoritesModal.classList.add('active')
    } else {
      addProgramToFavorite(item)
    }
  }
})

document.querySelectorAll('.program-question-button').forEach(item => {
  item.onclick = () => {
    if (document.body.dataset.auth === 'false') {
      questionAuthModal.classList.add('active')
    } else {
      questionModal.classList.add('active')
    }
  }
})

const disableQuestionRequest = false
addProgramQuestionButton.onclick = () => {
  if (disableQuestionRequest) {
    return
  }

  const value = questionModal.querySelector('textarea').value
  const modalError = questionModal.querySelector('.modal-error')
  modalError.innerHTML = ''

  if (value.length < 10) {
    modalError.innerHTML = 'Текст сообщения слишком короткий'
    return
  } else if (value.length > 1000) {
    modalError.innerHTML = 'Текст сообщения слишком длинный'
    return
  }

  addProgramQuestionButton.disabled = true

  axios.post(ADD_PROGRAM_QUESTION, {
    id: addProgramQuestionButton.dataset.id,
    question: value
  })
    .then(({data}) => {
      showAlert(data.message)
    })
    .catch((error) => showAlert(error.response.data.message))
    .finally(() => questionModal.classList.remove('active'))

  console.log(value)
}
