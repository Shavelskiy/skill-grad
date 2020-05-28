import React, { useState } from 'react'

import {useSelector} from 'react-redux'

import PageSwitcher from '../../pages/page-switcher'
import Sidebar from './../sidebar/sidebar'
import Header from './../header/header'
import Preloader from './../preloader/preloader'

import './main.scss'

const Main = () => {
  const [sidebarOpened, setSidebarOpened] = useState(true)
  const loading = useSelector(state => state.loading)

  return (
    <div className={`main ${!sidebarOpened ? 'active' : ''}`}>
      <Sidebar
        toggle={() => setSidebarOpened(!sidebarOpened)}
        opened={sidebarOpened}
      />
      <div className="main-content">
        <Header/>
        <Preloader active={loading}/>
        <PageSwitcher/>
      </div>
    </div>
  )
}

export default Main
