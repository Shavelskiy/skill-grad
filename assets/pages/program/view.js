import axios from 'axios'
import { ADD_PROGRAM_QUESTION } from '@/utils/api-routes'

import { loginModal, registerRoleModal, initModal, initRelationModal } from '@/components/modal'
import { addProgramToFavorite } from '@/components/common/favorite'
import showAlert from '@/components/modal/alert'
import { isAuth } from '@/helpers/auth'

import './view.scss'


const addFavoritesModal = document.getElementById('add-favorites-modal')
const questionAuthModal = document.getElementById('question-auth-modal')
const reviewAuthModal = document.getElementById('review-auth-modal')
const questionModal = document.getElementById('program-question-modal')
const addProgramQuestionButton = questionModal.querySelector('button')

initModal(addFavoritesModal)
initModal(questionAuthModal)
initModal(reviewAuthModal)
initModal(questionModal)

initRelationModal(addFavoritesModal, '.login-btn', loginModal)
initRelationModal(addFavoritesModal, '.register-btn', registerRoleModal)
initRelationModal(questionAuthModal, '.login-btn', loginModal)
initRelationModal(questionAuthModal, '.register-btn', registerRoleModal)
initRelationModal(reviewAuthModal, '.login-btn', loginModal)
initRelationModal(reviewAuthModal, '.register-btn', registerRoleModal)

document.querySelectorAll('.add-program-favorites').forEach(item => {
  item.onclick = () => {
    if (!isAuth()) {
      addFavoritesModal.classList.add('active')
    } else {
      addProgramToFavorite(item)
    }
  }
})

document.querySelectorAll('.program-question-button').forEach(item => {
  item.onclick = () => {
    if (!isAuth()) {
      questionAuthModal.classList.add('active')
    } else {
      questionModal.classList.add('active')
    }
  }
})

document.querySelectorAll('.program-review-button').forEach(item => {
  item.onclick = () => {
    if (!isAuth()) {
      reviewAuthModal.classList.add('active')
    } else {
      if (item.dataset.hasRequest === '0') {
        showAlert('Для того, чтобы поставить оценку, необходимо подать заявку к программе')
      } else {
        window.location.href = '/profile/learn'
      }
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
}
