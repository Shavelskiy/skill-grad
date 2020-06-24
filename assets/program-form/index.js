import React from 'react'
import ReactDOM from 'react-dom'

import { createStore } from 'redux'
import { Provider } from 'react-redux'
import { rootReducer } from './redux/rootReduser'

import App from './components/app'


const store = createStore(rootReducer)

const app = (
  <Provider store={store}>
    <App/>
  </Provider>
)

ReactDOM.render(app, document.getElementById('program-form-app'))
