import React, {useState, useEffect, useRef} from 'react'

import axios from 'axios'
import {MESSAGE_DETAIL_URL, MESSAGE_INDEX_URL} from '../../utils/api/endpoints'
import {CHAT_START} from '../../../utils/api-routes'
import {FOCUS_IN, FOCUS_OUT, INIT, SEND_MESSAGE} from '../../../chat/types'

import Sidebar from './sidebar'
import DetailChat from './detail-chat'

import css from './messages.scss?module'


const Messages = () => {
  const ref = useRef()

  const [socket, setSocket] = useState(null)
  const [token, setToken] = useState('')

  const [groups, setGroups] = useState([])
  const [selectedRecipientId, setSelectedRecipientId] = useState(null)
  const [writingUserIds, setWritingUserIds] = useState([])
  const [writing, setWriting] = useState(false)

  const [user, setUser] = useState(null)
  const [recipient, setRecipient] = useState(null)
  const [messages, setMessages] = useState([])

  const loadGroups = () => {
    axios.get(MESSAGE_INDEX_URL)
      .then(({data}) => {
        setGroups(data.groups)
      })
  }

  const loadMessages = () => {
    const recipientId = ref.current
    if (recipientId === null) {
      return
    }

    axios.get(MESSAGE_DETAIL_URL.replace(':id', recipientId))
      .then(({data}) => {
        setUser(data.user)
        setRecipient(data.recipient)
        setMessages(data.messages)
      })
  }

  const onMessage = ({data}) => {
    data = JSON.parse(data)
    switch (data.type) {
      case FOCUS_IN:
        const userFromInId = Number(data.from)
        if (!writingUserIds.includes(userFromInId)) {
          setWritingUserIds([...writingUserIds, userFromInId])
        }
        break
      case FOCUS_OUT:
        const userFromOutId = Number(data.from)
        setWritingUserIds(writingUserIds.filter((item) => item !== userFromOutId))
        break
      case SEND_MESSAGE:
        loadGroups()
        loadMessages()
        break
    }
  }

  const sendMessage = (message) => {
    if (socket === null || message.length < 1) {
      return
    }

    socket.send(JSON.stringify({
      type: SEND_MESSAGE,
      message: message,
      recipient: selectedRecipientId,
    }))

    loadMessages()
    loadGroups()
  }

  useEffect(() => {
    loadGroups()

    axios.get(CHAT_START)
      .then(({data}) => {
        setSocket(new WebSocket('ws://localhost:8081'))
        setToken(data.token)
      })

  }, [])

  useEffect(() => {
    ref.current = selectedRecipientId
    if (selectedRecipientId === null) {
      setUser(null)
      setRecipient(null)
      setMessages([])
      return
    }

    loadMessages()
  }, [selectedRecipientId])

  useEffect(() => {
    if (socket === null) {
      return
    }

    socket.send(JSON.stringify({
      type: writing ? FOCUS_IN : FOCUS_OUT,
      recipient: selectedRecipientId,
    }))
  }, [writing])

  useEffect(() => {
    if (socket === null || token === '') {
      return
    }

    socket.onopen = () => {
      socket.send(JSON.stringify({
        type: INIT,
        token: token
      }))
    }

    socket.onmessage = onMessage
  }, [socket, token])

  return (
    <div className="container-0 mt-40 non-margin-mobile">
      <div className={css.messages}>
        <Sidebar
          groups={groups}
          writingUserIds={writingUserIds}
          click={(recipientId) => setSelectedRecipientId(selectedRecipientId === recipientId ? null : recipientId)}
        />
        <DetailChat
          messages={messages}
          user={user}
          recipient={recipient}
          writing={writingUserIds.includes(selectedRecipientId)}
          setWriting={setWriting}
          sendMessage={sendMessage}
        />
      </div>
    </div>
  )
}

export default Messages
