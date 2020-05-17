import React from 'react';
import {
  BrowserRouter as Router,
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

class App extends React.Component {
  render() {
    return (
      <div className="main">
        <Sidebar/>
        <div className="main-content">
          <Header/>
          <div className="container-fluid px-4">
            <LocationsIndex/>
          </div>
        </div>
      </div>
    );
  }
}

export default App;
