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
import {NotFound} from '../pages/notFound/notFound';

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
              <Route exact path="/tag" component={TagsIndex} />
              <Route exact path="/location/:id" component={LocationView} />
              <Route exact path="/location" component={LocationsIndex} />
              <Route path="/" component={NotFound} />
            </Switch>
          </div>
        </div>
      </BrowserRouter>
    );
  }
}

export default App;


// let sidebarToggler = document.querySelector('.sidebar-toggler');
// sidebarToggler.addEventListener('click', function () {
//   this.classList.toggle('sidebar-toggler--active');
//   let content = document.getElementsByClassName('main')[0];
//   content.classList.toggle('main--active');
// });