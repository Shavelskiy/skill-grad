import React from 'react';
import { useSelector } from 'react-redux';
import { Switch, Route } from 'react-router-dom';
import css from './page-switcher.scss';

import LocationsIndex from '../pages/locations';
import LocationView from '../pages/locations/view';
import TagsIndex from '../pages/tags/index';
import TagView from '../pages/tags/view';
import TagCreate from '../pages/tags/create';
import NotFound from '../pages/not-found/not-found';

const PageSwitcher = () => {
  const loading = useSelector(state => state.loading);

  return (
    <div className={`page ${loading ? 'hidden' : ''}`}>
      <Switch>
        <Route exact name="tag.index" path="/tag" component={TagsIndex}/>
        <Route exact name="tag.create" path="/tag/create" component={TagCreate}/>
        <Route exact name="tag.view" path="/tag/:id" component={TagView}/>
        <Route exact name="location.index" path="/location/:id" component={LocationView}/>
        <Route exact name="location.view" path="/location" component={LocationsIndex}/>
        <Route path="/" component={NotFound}/>
      </Switch>
    </div>
  );
}

export default PageSwitcher;
