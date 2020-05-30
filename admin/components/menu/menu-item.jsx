import React, { useState } from 'react'
import { Link } from 'react-router-dom'

import css from './menu-item.scss?module'
import cn from 'classnames'


const MenuItem = ({rootItem, closed}) => {
  const [collapse, setCollapse] = useState(false)

  const items = rootItem.items.map((childItems, key) => {
    return (
      <li key={key}>
        <Link className={css.item} to={childItems.link}>
          <i className={css.point}><span></span></i>
          <span className={css.text}>{childItems.title}</span>
        </Link>
      </li>
    )
  })

  return (
    <li onClick={() => setCollapse(!collapse)} className={cn({[css.closed]: closed})}>
      <div className={cn(css.item, {[css.active]: collapse})}>
        <i className={rootItem.icon}></i>
        <div className={css.text}>
          {rootItem.title}
        </div>
        <i className={css.arrow}></i>
      </div>
      <ul className={cn(css.childItems, {[css.active]: collapse},)}>
        {items}
      </ul>
    </li>
  )
}

export default MenuItem
