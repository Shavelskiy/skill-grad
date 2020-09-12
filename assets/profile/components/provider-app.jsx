import React from 'react'
import {Route, Switch} from 'react-router-dom'

import {SETTINGS, PROGRAMS, PUBLICATIONS, MESSAGES, SERVICES} from '../utils/routes'

import ProviderMenu from './menu/provider-menu'

import Settings from './settings/settings'
import Programs from './programs/programs'
import Publications from './publications/publications'
import Messages from './messages/messages'
import Services from './services/services'

const ProviderApp = () => {
  return (
    <div className="main_profile">
      <h2 className="title">Личный кабинет провайдера</h2>
      <ProviderMenu/>

      <Switch>
        <Route exact name="profile.settings" path={SETTINGS} component={Settings}/>
        <Route exact name="profile.programs" path={PROGRAMS} component={Programs}/>
        <Route exact name="profile.publications" path={PUBLICATIONS} component={Publications}/>
        <Route exact name="profile.messages" path={MESSAGES} component={Messages}/>
        <Route exact name="profile.services" path={SERVICES} component={Services}/>
      </Switch>
    </div>
  )
}

export default ProviderApp
