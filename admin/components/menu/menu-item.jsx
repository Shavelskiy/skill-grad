import React, { useState, useEffect } from 'react'
import { Link, useLocation } from 'react-router-dom'

import css from './menu-item.scss?module'
import cn from 'classnames'


const MenuItem = ({rootItem, closed}) => {
  const [collapse, setCollapse] = useState(false)
  const location = useLocation()

  useEffect(() => {
    const isActive = rootItem.items.filter(item => {
      return location.pathname === item.link
    }).length > 0

    if (isActive) {
      setCollapse(true)
    }
  }, [])

  const items = rootItem.items.map((childItem, key) => {
    return (
      <li key={key}>
        <Link
          to={childItem.link}
          className={cn(css.item, {[css.active]: location.pathname === childItem.link})}
        >
          <i className={css.point}><span></span></i>
          <span className={css.text}>{childItem.title}</span>
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
        <div className={css.arrow}/>
      </div>
      <ul className={cn(css.childItems, {[css.active]: collapse})}>
        {items}
      </ul>
    </li>
  )
}

export default MenuItem
