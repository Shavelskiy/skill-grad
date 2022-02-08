import React from 'react'

import { textDateFormat } from '@/helpers/date-formater'

import css from './scss/sidebar-item.scss?module'
import cn from 'classnames'


const SidebarItem = ({group, click, writing}) => {
  const renderNotification = () => {
    if (group.new_count < 1) {
      return <></>
    }

    return <span className={css.notification}>{group.new_count}</span>
  }

  return (
    <div className={cn(css.user, {[css.newMessage]: !group.message.viewed})} onClick={click}>
      <div className={css.avatar}>
        <img className="rounded" src={group.user.image} alt=""/>
      </div>
      <div className="information w-100">
        <div className="d-flex j-c-space-between">
          <span className={css.name}>{group.user.name}</span>
          <span className={css.date}>{textDateFormat(new Date(group.message.date))}</span>
        </div>
        <div className={css.lastMessage}>
          {writing ? 'Печатает...' : group.message.message}
          {renderNotification()}
        </div>
      </div>
    </div>
  )
}

export default SidebarItem
