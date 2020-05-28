import React from 'react'
import ReactDOM from 'react-dom'

import { createStore } from 'redux'
import { Provider } from 'react-redux'
import { rootReducer } from './redux/rootReduser'

import App from './components/app'
import { BrowserRouter } from 'react-router-dom'


const store = createStore(rootReducer)

const app = (
  <Provider store={store}>
    <BrowserRouter basename={'/admin'}>
      <App/>
    </BrowserRouter>
  </Provider>
)

ReactDOM.render(app, document.getElementById('root'))
