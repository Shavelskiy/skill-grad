import React from 'react'
import ReactDOM from 'react-dom'

import {createStore, applyMiddleware} from 'redux'
import {Provider} from 'react-redux'
import {rootReducer} from './redux/root-reducer'

import UserApp from './components/user-app'
import {BrowserRouter} from 'react-router-dom'

const middlewares = []

if (process.env.NODE_ENV === `development`) {
  const {logger} = require(`redux-logger`)

  middlewares.push(logger)
}

const store = createStore(rootReducer, applyMiddleware(...middlewares))


const app = (
  <Provider store={store}>
    <BrowserRouter basename={'/profile'}>
      <UserApp/>
    </BrowserRouter>
  </Provider>
)

ReactDOM.render(app, document.getElementById('profile-app'))
