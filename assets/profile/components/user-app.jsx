import React from 'react'
import {Route, Switch} from 'react-router-dom'

import {LEARN, MESSAGES, SETTINGS} from '../utils/routes'

import UserMenu from './menu/user-menu'

import Settings from './settings/settings'
import Messages from './messages/messages'
import Learn from './learn/learn'


const UserApp = () => {
  return (
    <div className="main_profile">
      <h2 className="title">Личный кабинет обучающегося</h2>
      <UserMenu/>

      <Switch>
        <Route exact name="profile.settings" path={SETTINGS} component={Settings}/>
        <Route exact name="profile.messages" path={MESSAGES} component={Messages}/>
        <Route exact name="profile.learn" path={LEARN} component={Learn}/>
      </Switch>
    </div>
  )
}

export default UserApp
