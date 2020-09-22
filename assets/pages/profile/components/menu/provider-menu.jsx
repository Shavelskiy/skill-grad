import React from 'react'

import {Link, useLocation} from 'react-router-dom'
import {
  SETTINGS,
  PROGRAMS,
  PUBLICATIONS,
  MESSAGES,
  SERVICES,
} from '@/utils/profile/routes'

import css from './menu.scss?module'
import cn from 'classnames'


const ProviderMenu = () => {
  const location = useLocation()

  return (
    <div className={css.menu}>
      <ul className={css.provider}>
        <li className={cn({[css.active]: location.pathname === SETTINGS})}>
          <i className="icon-gear"></i>
          <Link to={SETTINGS}>Настройки профиля</Link>
        </li>
        <li className={cn({[css.active]: location.pathname.indexOf(PROGRAMS) === 0})}>
          <i className="icon-web-development"></i>
          <Link to={PROGRAMS}>Программы обучения</Link>
        </li>
        <li className={cn({[css.active]: location.pathname === PUBLICATIONS})}>
          <i className="icon-contract"></i>
          <Link to={PUBLICATIONS}>Публикации</Link>
        </li>
        <li className={cn({[css.active]: location.pathname === MESSAGES})}>
          <i className="icon-email1"></i>
          <Link to={MESSAGES}>Сообщения</Link>
        </li>
        <li className={cn({[css.active]: location.pathname === SERVICES})}>
          <i className="icon-google"></i>
          <Link to={SERVICES}>Платные услги, документы</Link>
        </li>
      </ul>

      <i className={css.iconDownArrow}></i>
    </div>
  )
}

export default ProviderMenu
