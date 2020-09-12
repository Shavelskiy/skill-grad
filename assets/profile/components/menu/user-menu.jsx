import React from 'react'

import {Link, useLocation} from 'react-router-dom'
import {LEARN, MESSAGES, SETTINGS} from '../../utils/routes'

import cn from 'classnames'
import css from './menu.scss?module'

const UserMenu = () => {
  const location = useLocation()

  return (
    <div className={css.menu}>
      <ul>
        <li className={cn({[css.active]: location.pathname === SETTINGS})}>
          <i className="icon-gear"></i>
          <Link to={SETTINGS}>Настройки профиля</Link>
        </li>
        <li className={cn({[css.active]: location.pathname === MESSAGES})}>
          <i className="icon-email1"></i>
          <Link to={MESSAGES}>Сообщения</Link>
        </li>
        <li className={cn({[css.active]: location.pathname === LEARN})}>
          <i className="icon-student"></i>
          <Link to={LEARN}>Мое обучение</Link>
        </li>
      </ul>

      <i className={css.iconDownArrow}></i>
    </div>
  )
}

export default UserMenu
