import React from 'react'
import ReactDOM from 'react-dom'

import { createStore, compose, applyMiddleware } from 'redux'
import { Provider } from 'react-redux'
import { rootReducer } from './redux/rootReduser'

import App from './components/app'


const middlewares = []

if (process.env.NODE_ENV === `development`) {
  const { logger } = require(`redux-logger`);

  middlewares.push(logger)
}

const store = compose(applyMiddleware(...middlewares))(createStore)(rootReducer)

const app = (
  <Provider store={store}>
    <App/>
  </Provider>
)

ReactDOM.render(app, document.getElementById('program-form-app'))
