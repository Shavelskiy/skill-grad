import React from 'react'

import ProfileMenu from './profile-menu'

import css from './header.scss?module'


const Header = () => {
  return (
    <div className={css.header}>
      <ProfileMenu/>
    </div>
  )
}

export default Header