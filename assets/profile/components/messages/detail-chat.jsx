import React, {useEffect, useState} from 'react'

import axios from 'axios'
import {MESSAGE_DETAIL_URL} from '../../utils/api/endpoints'

import DetailChatItem from './detail-chat-item'

import css from './detail-chat.scss?module'
import cn from 'classnames'


const DetailChat = ({recipientId}) => {
  const [user, setUser] = useState(null)
  const [recipient, setRecipient] = useState(null)
  const [messages, setMessages] = useState([])

  useEffect(() => {
    if (recipientId === null) {
      setUser(null)
      setRecipient(null)
      setMessages([])
      return
    }

    axios.get(MESSAGE_DETAIL_URL.replace(':id', recipientId))
      .then(({data}) => {
        setUser(data.user)
        setRecipient(data.recipient)
        setMessages(data.messages)
      })
  }, [recipientId])

  if (recipientId === null || user === null || recipient === null) {
    return (
      <div className={cn(css.content, css.empty)}>
        <h6>Выберите собеседника...</h6>
      </div>
    )
  }

  return (
    <div className={css.content}>
      <div className={css.headerContent}>
        <i className={css.iconLeft}></i>
        <div className={css.avatar}>
          <img className="rounded" src="../../../img/photo.jpg" alt=""/>
        </div>
        <div className={css.info}>
          Автор беседы: <a href="#">{recipient.name}</a>
        </div>
      </div>
      <div className={css.box}>
        {messages.map((item, key) => <DetailChatItem key={key} message={item} user={user} recipient={recipient}/>)}
      </div>
      <div className={css.textareaBox}>
        <textarea rows="10" className="textarea" placeholder="Текст сообщения"></textarea>
      </div>
    </div>
  )
}

export default DetailChat