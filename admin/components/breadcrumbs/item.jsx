import React from 'react'
import { Link } from 'react-router-dom'

import css from './item.scss?module'
import cx from 'classnames'


const BreadcrumbItem = ({item}) => {
  const renderContent = () => {
    if (item.link === null) {
      return <span>{item.title}</span>
    } else {
      return <Link to={item.link}>{item.title}</Link>
    }
  }

  return (
    <li className={cx(css.item, {[css.active]: item.link === null})}>
      {renderContent()}
    </li>
  )
}

export default BreadcrumbItem