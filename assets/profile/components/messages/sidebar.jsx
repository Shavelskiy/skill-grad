import React from 'react'
import SidebarItem from './sidebar-item'

import css from './sidebar.scss?module';


const Sidebar = ({groups, click}) => {
  return (
    <div className={css.sidebar}>
      <div className={css.search}>
        <div className="input-search-gray">
          <input type="text" placeholder="Поиск собеседника"/>
          <i className="icon-search"></i>
        </div>
      </div>
      <div className={css.users}>
        {groups.map((group, key) => (
          <SidebarItem key={key} group={group} click={() => click(group.recipient.id)}/>
        ))}
      </div>
    </div>
  )
}

export default Sidebar
