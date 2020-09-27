import axios from 'axios'
import {ARTICLE_LIKE} from '@/utils/api-routes'

document.querySelectorAll('.article-like-block').forEach(block => {
  let disableRequest = false

  const likeButton = block.querySelector('.add-article-like')
  const dislikeButton = block.querySelector('.add-article-dislike')

  likeButton.onclick = () => likeAction('like', likeButton, dislikeButton)
  dislikeButton.onclick = () => likeAction('dislike', dislikeButton, likeButton)

  const likeAction = (action, button, oppositeButton) => {
    if (button.classList.contains('disabled') || disableRequest) {
      return
    }

    disableRequest = true

    axios.post(ARTICLE_LIKE, {
      id: block.dataset.id,
      action: action,
    })
      .then(() => {
        const actionCount = Number(button.parentElement.querySelector('.likes-count').innerHTML)
        const oppositeCount = Number(oppositeButton.parentElement.querySelector('.likes-count').innerHTML)

        if (oppositeButton.classList.contains('active')) {
          oppositeButton.classList.remove('active')
          oppositeButton.parentElement.querySelector('.likes-count').innerHTML = String(oppositeCount - 1)
        }

        if (button.classList.contains('active')) {
          button.classList.remove('active')
          button.parentElement.querySelector('.likes-count').innerHTML = String(actionCount - 1)
        } else {
          button.classList.add('active')
          button.parentElement.querySelector('.likes-count').innerHTML = String(actionCount + 1)
        }

        disableRequest = false
      })
  }
})
