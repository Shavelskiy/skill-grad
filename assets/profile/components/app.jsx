import React from 'react'
import { Route, Switch } from 'react-router-dom'

import { LEARN, MESSAGES, SETTINGS } from '../utils/routes'

import Menu from './menu/menu'

import Settings from './settings/settings'
import Messages from './messages/messages'
import Learn from './learn/learn'


const App = () => {
  return (
    <div className="container">
      <div className="col-lg-12 mobile-no-gutter">
        <div className="main_profile">
          <h2 className="title">Личный кабинет обучающегося</h2>
          <Menu/>

          <Switch>
            <Route exact name="profile.settings" path={SETTINGS} component={Settings}/>
            <Route exact name="profile.messages" path={MESSAGES} component={Messages}/>
            <Route exact name="profile.learn" path={LEARN} component={Learn}/>
          </Switch>
        </div>
      </div>
    </div>
  )
}

export default App
