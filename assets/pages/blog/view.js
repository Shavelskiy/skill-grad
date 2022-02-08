import './view.scss'

import axios from 'axios'
import { ADD_ARTICLE_COMMENT, DELETE_ARTICLE_COMMENT, EDIT_ARTICLE_COMMENT } from '@/utils/api-routes'

import { loginModal, registerRoleModal, initModal, initRelationModal } from '@/components/modal'
import { addArticleToFavorite } from '@/components/common/favorite'
import { isAuth } from '@/helpers/auth'


const addFavoritesModal = document.getElementById('add-favorites-modal')
const sendCommentBlock = document.querySelector('.send-comment')
const editPopup = document.getElementById('comment-edit-popup')
const answerPopup = document.getElementById('comment-answer-popup')

initModal(addFavoritesModal)
initModal(editPopup)
initModal(answerPopup)

initRelationModal(addFavoritesModal, '.login-btn', loginModal)
initRelationModal(addFavoritesModal, '.register-btn', registerRoleModal)

document.querySelectorAll('.add-article-favorites').forEach(item => {
  item.onclick = () => {
    if (!isAuth()) {
      addFavoritesModal.classList.add('active')
    } else {
      addArticleToFavorite(item)
    }
  }
})

if (sendCommentBlock) {
  const sendButton = sendCommentBlock.querySelector('button')

  sendButton.onclick = () => {
    if (sendCommentBlock.querySelector('textarea').value.length < 1) {
      return
    }

    sendButton.disabled = true

    axios.post(ADD_ARTICLE_COMMENT, {
      'id': sendCommentBlock.dataset.id,
      'text': sendCommentBlock.querySelector('textarea').value,
    })
      .finally(() => document.location.reload())
  }
}

document.querySelectorAll('.delete-article-comment').forEach(item => {
  item.onclick = () => {
    if (!window.confirm('Вы уверены что хотите удалить комментарий?')) {
      return
    }

    axios.delete(DELETE_ARTICLE_COMMENT.replace(':id', item.dataset.id))
      .finally(() => document.location.reload())
  }
})

document.querySelectorAll('.edit-article-comment').forEach(item => {
  item.onclick = () => {
    editPopup.classList.add('active')
    editPopup.querySelector('textarea').value = item.dataset.value

    editPopup.querySelector('button').onclick = () => {
      if (editPopup.querySelector('textarea').value.length < 1) {
        return
      }

      axios.put(EDIT_ARTICLE_COMMENT.replace(':id', item.dataset.id), {
        text: editPopup.querySelector('textarea').value
      })
        .finally(() => document.location.reload())
    }
  }
})


document.querySelectorAll('.answer-article-comment').forEach(item => {
  item.onclick = () => {
    answerPopup.classList.add('active')

    answerPopup.querySelector('button').onclick = () => {
      if (answerPopup.querySelector('textarea').value.length < 1) {
        return
      }

      answerPopup.querySelector('button').disabled = true

      axios.post(ADD_ARTICLE_COMMENT, {
        'parent_comment_id': item.dataset.id,
        'text': answerPopup.querySelector('textarea').value,
      })
        .finally(() => document.location.reload())
    }
  }
})

const defaultCommentsTab = document.querySelector('.comments-tab-default')
const popularCommentTab = document.querySelector('.comments-tab-popular')

if (defaultCommentsTab !== null && popularCommentTab !== null) {
  const defaultCommentsTabContent = document.querySelector('.comments-tab-content-default')
  const popularCommentTabContent = document.querySelector('.comments-tab-content-popular')

  defaultCommentsTab.onclick = () => {
    if (defaultCommentsTab.classList.contains('active')) {
      return
    }

    popularCommentTab.classList.remove('active')
    popularCommentTabContent.classList.remove('active')
    defaultCommentsTab.classList.add('active')
    defaultCommentsTabContent.classList.add('active')
  }

  popularCommentTab.onclick = () => {
    if (popularCommentTab.classList.contains('active')) {
      return
    }

    defaultCommentsTab.classList.remove('active')
    defaultCommentsTabContent.classList.remove('active')
    popularCommentTab.classList.add('active')
    popularCommentTabContent.classList.add('active')
  }
}
