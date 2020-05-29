import React from 'react'

export const Item = ({active, page, click}) => {
  return (
    <li
      className={`link ${active ? 'active' : ''}`}
      onClick={() => click(page)}
    >
      <span>{page}</span>
    </li>
  )
}

export const EmptyItem = () => {
  return (
    <li className="link">
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
      className={`link ${!active ? 'disabled' : ''}`}
      onClick={() => onClick()}
    >
      {arrow}
    </li>
  )
}
