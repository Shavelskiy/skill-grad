import React, { useState } from 'react';
import { BrowserRouter, Switch, Route } from 'react-router-dom';

import './app.scss'
import Sidebar from './sidebar/sidebar';
import Header from './header/header';
import Preloader from './preloader/preloader';
import LocationsIndex from '../pages/locations';
import LocationView from '../pages/locations/view';
import TagsIndex from '../pages/tags/index';
import TagView from '../pages/tags/view';
import TagCreate from '../pages/tags/create';
import NotFound from '../pages/not-found/not-found';

const App = () => {
  const [sidebarOpened, setSidebarOpened] = useState(true);

  return (
    <BrowserRouter basename={'/admin'}>
      <div className={`main ${!sidebarOpened ? 'active' : ''}`}>
        <Sidebar
          toggle={() => setSidebarOpened(!sidebarOpened)}
          opened={sidebarOpened}
        />
        <div className="main-content">
          <Preloader/>
          <Header/>
          <Switch>
            <Route exact name="tag.index" path="/tag" component={TagsIndex}/>
            <Route exact name="tag.create" path="/tag/create" component={TagCreate}/>
            <Route exact name="tag.view" path="/tag/:id" component={TagView}/>
            <Route exact name="location.index" path="/location/:id" component={LocationView}/>
            <Route exact name="location.view" path="/location" component={LocationsIndex}/>
            <Route path="/" component={NotFound}/>
          </Switch>
        </div>
      </div>
    </BrowserRouter>
  );
}

export default App;
