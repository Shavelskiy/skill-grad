import axios from 'axios'
import {SEND_MESSAGE, VIEWED} from './types'
import {GET_NEW_MESSAGES_COUNT} from '../utils/api-routes'
import {isAuth} from '../helpers/auth'

if (isAuth()) {
  const headerNotificationCount = document.querySelector('.header-notification-count')

  axios.get('/chat/start')
    .then(response => {
      const socket = new WebSocket('ws://localhost:8081')
      const token = response.data.token

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

      socket.onopen = () => {
        socket.send(JSON.stringify({
          type: 'init',
          token: token
        }))
      }

      socket.onmessage = ({data}) => {
        data = JSON.parse(data)
        console.log(data)
        switch (data.type) {
          case VIEWED:
            updateNotificationCount()
            break
          case SEND_MESSAGE:
            updateNotificationCount()
            break
        }
      }
    })
}
