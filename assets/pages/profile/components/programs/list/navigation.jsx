import React from 'react'

import css from './scss/navigation.scss?module'
import cn from 'classnames'


const Navigation = ({activeTab, setActiveTab}) => {
  return (
    <div className={css.navigation}>
      <ul className={css.nav}>
        <li className={cn(css.item, {[css.active]: activeTab})} onClick={() => setActiveTab(true)}>
          Активные
        </li>
        <li className={cn(css.item, {[css.active]: !activeTab})} onClick={() => setActiveTab(false)}>
          Неактивные
        </li>
      </ul>
      <a href="/program-create" className={cn('button-blue', css.buttonBlue)}>Добавить программу обучения</a>
    </div>
  )
}

export default Navigation
