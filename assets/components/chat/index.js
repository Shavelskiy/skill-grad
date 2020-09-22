import axios from 'axios'
import {INIT, SEND_MESSAGE, VIEWED} from '@/utils/chat-types'
import {GET_NEW_MESSAGES_COUNT} from '@/utils/api-routes'
import {isAuth} from '@/helpers/auth'

if (isAuth()) {
  const headerNotificationCount = document.querySelector('.header-notification-count')
  const newMessageModal = document.querySelector('.new-message-modal')

  axios.get('/chat/start')
    .then(initChat)

  const initChat = ({data}) => {
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

    const sendMessage = () => {
      socket.send(JSON.stringify({
        type: SEND_MESSAGE,
        message: message,
        recipient: selectedRecipientId,
      }))
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
            newMessageModal.classList.add('active')

            setTimeout(() => {
              newMessageModal.classList.remove('active')
            }, 5000)
          }

          break
      }
    }

    document.querySelectorAll('.send-email').forEach(item => {
      item.onclick = () => {

      }
    })
  }
}
