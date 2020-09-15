import React from 'react'

import css from './navigation.scss?module'
import cn from 'classnames'

const Navigation = () => {
  return (
    <div className={css.navigation}>
      <ul className={css.nav}>
        <li className={cn(css.item, css.active)}>Активные</li>
        <li className={css.item}>Неактивные</li>
      </ul>
      <a href="/program-create" className={cn('button-blue', css.buttonBlue)}>Добавить программу обучения</a>
    </div>
  )
}

export default Navigation
