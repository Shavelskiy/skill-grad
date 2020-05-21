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
import TagsIndex from "../pages/tags";
import {NotFound} from '../pages/not-found/not-found';

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      sidebarOpened: true,
    };
  }

  toggle() {
    const sidebarOpened = this.state.sidebarOpened;
    this.setState({
      sidebarOpened: !sidebarOpened
    });
  }

  render() {
    return (
      <BrowserRouter basename={'/admin'}>
        <div className={`main ${!this.state.sidebarOpened ? 'active' : ''}`}>
          <Sidebar
            toggle={() => this.toggle()}
            opened={this.state.sidebarOpened}
          />
          <div className="main-content">
            <Header/>
            <Switch>
              <Route exact name="tag.index" path="/tag" component={TagsIndex} />
              <Route exact name="tag.view" path="/tag/:id" component={LocationView} />
              <Route exact name="location.index" path="/location/:id" component={LocationView} />
              <Route exact name="location.view" path="/location" component={LocationsIndex} />
              <Route path="/" component={NotFound} />
            </Switch>
          </div>
        </div>
      </BrowserRouter>
    );
  }
}

export default App;
