import React from 'react'
import { Link } from 'react-router-dom'

import Toggler from './toggler'
import Menu from '../menu/menu'

import css from './sidebar.scss?module'
import cn from 'classnames'

import logo from '../../images/logo.png'


const Sidebar = ({opened, toggle}) => {
  return (
    <div className={cn(css.container, {[css.closed]: !opened})}>
      <div className={css.header}>
        <div className={css.logo}>
          <Link to="/">
            <img alt="Logo" src={logo}/>
          </Link>
        </div>
        <div className={css.toolsWrapper}>
          <Toggler
            active={!opened}
            click={() => toggle()}
          />
        </div>
      </div>

      <Menu closed={!opened}/>
    </div>
  )
}

export default Sidebar
