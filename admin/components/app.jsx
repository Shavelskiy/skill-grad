import React, { useEffect, useState } from 'react'
import { Switch, Route, useHistory } from 'react-router-dom'
import { INDEX, LOGIN } from '../utils/routes'

import { useDispatch } from 'react-redux'
import { hideLoader, setTitle, showLoader, setCurrentUser, loadApp } from '../redux/actions'

import axios from 'axios'
import { INFO_URL } from '../utils/api/endpoints'

import Main from './main/main'
import Preloader from './preloader/preloader'
import Login from './../pages/login/login'


const App = () => {
  const dispatch = useDispatch()
  const history = useHistory()

  const [loadingApp, setLoadingApp] = useState(true)

  useEffect(() => {
    axios.get(INFO_URL)
      .then(({data}) => {
        dispatch(setCurrentUser(data.current_user))
      })
      .catch(() => {
        history.push(LOGIN)
      })
      .finally(() => {
        setLoadingApp(false)
      })
  }, [])

  if (loadingApp) {
    return <Preloader active={loadingApp}/>
  }

  return (
    <Switch>
      <Route exact path={LOGIN} component={Login}/>
      <Route path={INDEX} component={Main}/>
    </Switch>
  )
}

export default App
