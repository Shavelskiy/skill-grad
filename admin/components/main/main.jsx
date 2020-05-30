import React, { useState } from 'react'

import { useSelector } from 'react-redux'

import PageSwitcher from '../../pages/page-switcher'
import Sidebar from './../sidebar/sidebar'
import Header from './../header/header'
import Preloader from './../preloader/preloader'

import css from './main.scss?module'
import cn from 'classnames'


const Main = () => {
  const [sidebarOpened, setSidebarOpened] = useState(true)
  const loading = useSelector(state => state.loading)

  return (
    <div className={css.main}>
      <Sidebar
        toggle={() => setSidebarOpened(!sidebarOpened)}
        opened={sidebarOpened}
      />
      <div className={cn(css.container, {[css.active]: !sidebarOpened})}>
        <Header/>
        <Preloader active={loading}/>
        <PageSwitcher active={!loading}/>
      </div>
    </div>
  )
}

export default Main
