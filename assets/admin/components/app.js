import React from 'react';
import {
  BrowserRouter,
  Switch,
  Route,
  Link,
  useRouteMatch,
  useParams
} from 'react-router-dom';

import './app.scss'
import Sidebar from './sidebar/sidebar';
import Header from './header/header';
import Table from './table/table';
import LocationsIndex from '../pages/locations';
import LocationView from '../pages/locations/view';
import {NotFound} from '../pages/notFound/notFound';

class App extends React.Component {
  render() {
    return (
      <BrowserRouter basename={'/admin'}>
        <div className="main">
          <Sidebar/>
          <div className="main-content">
            <Header/>
            <Switch>
              <Route path={/\/location\/([0-9]+)\/$/} component={LocationView}/>
              <Route path={/\/location\/$/} component={LocationsIndex}/>
              <Route path={/.*/} component={NotFound}/>
            </Switch>
          </div>
        </div>
      </BrowserRouter>
    );
  }
}

export default App;
