import React from 'react'

import cn from 'classnames'


export const Item = ({active, page, click}) => {
  return (
    <a className={cn({'active': active})} onClick={() => click(page)}>
      {page}
    </a>
  )
}

export const EmptyItem = () => {
  return (
    <span>...</span>
  )
}

export const Arrow = ({left, click, active, page}) => {
  const onClick = () => {
    if (!active) {
      return
    }

    click(page)
  }

  return (
    <a onClick={() => onClick()}>
      <span className={cn({'prev': left, 'next': !left})}></span>
    </a>
  )
}
