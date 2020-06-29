import React from 'react'
import ReactDOM from 'react-dom'

import { createStore, compose, applyMiddleware, combineReducers } from 'redux'
import { Provider } from 'react-redux'
import { dataReduser } from './redux/data/data-reduser'
import { programReduser } from './redux/program/program-reduser'

import App from './components/app'


const middlewares = []

if (process.env.NODE_ENV === `development`) {
  const {logger} = require(`redux-logger`)

  middlewares.push(logger)
}

const store = compose(applyMiddleware(...middlewares))(createStore)(combineReducers({
  program: programReduser,
  data: dataReduser
}))

const app = (
  <Provider store={store}>
    <App/>
  </Provider>
)

ReactDOM.render(app, document.getElementById('program-form-app'))
