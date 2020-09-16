import React from 'react'
import ReactDOM from 'react-dom'

import { createStore } from 'redux'
import { Provider } from 'react-redux'
import { rootReducer } from './redux/root-reducer'

import App from './components/app'
import { BrowserRouter } from 'react-router-dom'

import './index.scss'


const store = createStore(rootReducer)

const app = (
  <Provider store={store}>
    <BrowserRouter basename={'/admin'}>
      <App/>
    </BrowserRouter>
  </Provider>
)

ReactDOM.render(app, document.getElementById('root'))
