import React from 'react'
import ReactDOM from 'react-dom'

import { createStore, compose, applyMiddleware, combineReducers } from 'redux'
import { Provider } from 'react-redux'
import { dataReducer } from './redux/data/data-reducer'
import { programReducer } from './redux/program/program-reducer'
import { validationReducer } from './redux/validation/validation-reducer'

import App from './components/app'


const middlewares = []

if (process.env.NODE_ENV === `development`) {
  const {logger} = require(`redux-logger`)

  // middlewares.push(logger)
}

const store = compose(applyMiddleware(...middlewares))(createStore)(combineReducers({
  program: programReducer,
  data: dataReducer,
  validation: validationReducer,
}))

const app = (
  <Provider store={store}>
    <App/>
  </Provider>
)

ReactDOM.render(app, document.getElementById('program-form-app'))
