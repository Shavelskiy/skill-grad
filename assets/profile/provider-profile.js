import React from 'react'
import ReactDOM from 'react-dom'

// import { createStore } from 'redux'
// import { Provider } from 'react-redux'
// import { rootReducer } from './redux/rootReduser'

import ProviderApp from './components/provider-app'
import { BrowserRouter } from 'react-router-dom'

// const store = createStore(rootReducer)

const app = (
  // <Provider store={store}>
  <BrowserRouter basename={'/profile'}>
    <ProviderApp/>
  </BrowserRouter>
  // </Provider>
)

ReactDOM.render(app, document.getElementById('profile-app'))
