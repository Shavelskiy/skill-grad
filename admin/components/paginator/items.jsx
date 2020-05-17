import React from 'react'

import css from './items.scss?module'
import cx from 'classnames'


export const Item = ({active, page, click}) => {
  return (
    <li
      className={cx(css.link, {[css.active]: active})}
      onClick={() => click(page)}
    >
      <span>{page}</span>
    </li>
  )
}

export const EmptyItem = () => {
  return (
    <li className={css.link}>
      <span>...</span>
    </li>
  )
}

export const Arrow = ({left, click, active, page}) => {
  const onClick = () => {
    if (!active) {
      return
    }

    click(page)
  }

  let arrow = ''
  if (left) {
    arrow = (<span>&laquo;</span>)
  } else {
    arrow = (<span>&raquo;</span>)
  }

  return (
    <li
      className={cx(css.link, {[css.disabled]: !active})}
      onClick={() => onClick()}
    >
      {arrow}
    </li>
  )
}
