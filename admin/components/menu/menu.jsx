import React from 'react'

import MenuItem from './menu-item'

import css from './menu.scss?module'

import { menuItems } from './items'


const Menu = ({closed}) => {
  const items = menuItems.map((rootItem, key) => {
    return (
      <MenuItem rootItem={rootItem} closed={closed} key={key}/>
    )
  })

  return (
    <div className={css.menuContainer}>
      <ul>{items}</ul>
    </div>
  )
}

export default Menu
