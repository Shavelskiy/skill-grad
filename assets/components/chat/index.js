import axios from 'axios'
import { INIT, SEND_MESSAGE, VIEWED } from '@/utils/chat-types'
import { GET_NEW_MESSAGES_COUNT, CHAT_START } from '@/utils/api-routes'
import { isAuth } from '@/helpers/auth'
import { initModal } from '@/components/modal'
import showAlert from '@/components/modal/alert'


if (isAuth()) {
  const headerNotificationCount = document.querySelector('.header-notification-count')
  const newMessageModal = document.querySelector('.new-message-modal')

  axios.get(CHAT_START)
    .then(({data}) => initChat(data))

  const initChat = (data) => {
    const socket = new WebSocket('ws://localhost:8081')
    const token = data.token

    const updateNotificationCount = () => {
      axios.get(GET_NEW_MESSAGES_COUNT)
        .then(({data}) => {
          headerNotificationCount.innerHTML = data.count

          if (data.count > 0) {
            headerNotificationCount.classList.add('active')
          } else {
            headerNotificationCount.classList.remove('active')
          }
        })
    }

    const messageModal = document.getElementById('send-new-message-modal')
    if (messageModal !== null) {
      initModal(messageModal)

      const modalError = messageModal.querySelector('.modal-error')
      let userId, message

      document.querySelectorAll('.send-message-button').forEach(sendMessageButton => {
        sendMessageButton.onclick = () => {
          userId = Number(sendMessageButton.dataset.userId)
          messageModal.classList.add('active')
        }
      })

      messageModal.querySelector('button').onclick = () => {
        modalError.innerHTML = ''

        message = messageModal.querySelector('textarea').value

        if (message.length < 1) {
          modalError.innerHTML = 'Введите сообщение'
          return
        }

        if (userId < 1) {
          modalError.innerHTML = 'Отправка сообщения невозможна'
          return
        }

        socket.send(JSON.stringify({
          type: SEND_MESSAGE,
          message: message,
          recipient: userId,
        }))

        messageModal.querySelector('textarea').value = ''
        messageModal.classList.remove('active')
        showAlert('Сообщение успешно отправлено')
      }
    }

    socket.onopen = () => {
      socket.send(JSON.stringify({
        type: INIT,
        token: token
      }))
    }

    socket.onmessage = ({data}) => {
      data = JSON.parse(data)
      switch (data.type) {
        case VIEWED:
          updateNotificationCount()
          break
        case SEND_MESSAGE:
          updateNotificationCount()

          if ('text' in data) {
            newMessageModal.querySelector('.message-text').innerHTML = data.text
            newMessageModal.querySelector('.author').innerHTML = data.author.name

            const authorImage = newMessageModal.querySelector('.rounded')
            authorImage.src = data.author.image
            newMessageModal.classList.add('active')

            setTimeout(() => {
              newMessageModal.classList.remove('active')
            }, 5000)
          }

          break
      }
    }
  }
}
