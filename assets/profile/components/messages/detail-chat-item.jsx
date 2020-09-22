import React from 'react'

import {textDateFormat, timeFormat} from '../../helpers/date-fromater'

import css from './scss/detail-chat.scss?module'
import cn from 'classnames'


const DetailChatItem = ({message, user, recipient}) => {
  return (
    <div className={cn(css.user, {[css.newMessage]: !message.viewed}, {[css.my]: message.user === user.id})}>
      <div className={css.avatar}>
        <img className="rounded" src="../../../img/photo.jpg" alt=""/>
      </div>
      <div className="information w-100">
        <div className="d-flex j-c-space-between">
          <a className={css.name} href="#">
            {message.user === user.id ? user.name : recipient.name}
          </a>
          <span className={css.date}>
            <span className="day">{textDateFormat(new Date(message.date))}, </span>
            <span className="time">{timeFormat(new Date(message.date))}</span>
          </span>
        </div>
        <div className={css.lastMessage}>
          {message.message}
        </div>
      </div>
    </div>
  )
}

export default DetailChatItem
