import React from 'react'
import { useSelector } from 'react-redux'
import { Switch, Route } from 'react-router-dom'
import css from './page-switcher.scss'

import IndexPage from './index'
import LocationsIndex from '../pages/locations'
import LocationView from '../pages/locations/view'
import TagsIndex from '../pages/tags/index'
import TagView from '../pages/tags/view'
import TagCreate from '../pages/tags/create'
import NotFoundPage from '../pages/not-found/not-found'
import TagUpdate from './tags/update'
import Breadcrumbs from '../components/breadcrumbs/breacrumbs';

const PageSwitcher = () => {
  const loading = useSelector(state => state.loading)
  const breadcrumbs = useSelector(state => state.breadcrumbs)

  return (
    <div className={`page ${loading ? 'hidden' : ''}`}>
      <Breadcrumbs items={breadcrumbs}/>

      <Switch>
        <Route exact name="tag.index" path="/tag" component={TagsIndex}/>
        <Route exact name="tag.create" path="/tag/create" component={TagCreate}/>
        <Route exact name="tag.view" path="/tag/:id" component={TagView}/>
        <Route exact name="tag.update" path="/tag/update/:id" component={TagUpdate}/>
        <Route exact name="location.index" path="/location/:id" component={LocationView}/>
        <Route exact name="location.view" path="/location" component={LocationsIndex}/>
        <Route exact name="index" path="/" component={IndexPage}/>
        <Route path="/" component={NotFoundPage}/>
      </Switch>
    </div>
  )
}

export default PageSwitcher
