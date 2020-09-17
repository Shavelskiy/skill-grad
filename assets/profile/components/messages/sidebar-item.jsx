import React from 'react'

import {textDateFormat} from '../../helpers/date-fromater'

import css from './sidebar-item.scss?module'
import cn from 'classnames'


const SidebarItem = ({group, click}) => {
  return (
    <div className={cn(css.user, css.newMessage)} onClick={click}>
      <div className={css.avatar}>
        <img className="rounded" src="../../../img/photo.jpg" alt=""/>
      </div>
      <div className="information w-100">
        <div className="d-flex j-c-space-between">
          <span className={css.name}>{group.recipient.name}</span>
          <span className={css.date}>{textDateFormat(new Date(group.message.date))}</span>
        </div>
        <div className={css.lastMessage}>
          {group.message.message}
          <span className={css.notification}>10</span>
        </div>
      </div>
    </div>
  )
}

export default SidebarItem
