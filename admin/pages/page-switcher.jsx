import React from 'react'
import { Switch, Route } from 'react-router-dom'
import { INDEX, LOCATION_INDEX, LOCATION_VIEW, TAG_CREATE, TAG_INDEX, TAG_UPDATE, TAG_VIEW } from './../utils/routes'

import { useSelector } from 'react-redux'

import Breadcrumbs from '../components/breadcrumbs/breacrumbs';
import IndexPage from './index'
import LocationsIndex from '../pages/locations'
import LocationView from '../pages/locations/view'
import TagsIndex from '../pages/tags/index'
import TagView from '../pages/tags/view'
import TagCreate from '../pages/tags/create'
import NotFoundPage from '../pages/not-found/not-found'
import TagUpdate from './tags/update'

import css from './page-switcher.scss?module'
import cn from 'classnames'


const PageSwitcher = ({active}) => {
  const breadcrumbs = useSelector(state => state.breadcrumbs)

  return (
    <div className={cn(css.page, {[css.hidden]: !active})}>
      <Breadcrumbs items={breadcrumbs}/>

      <Switch>
        <Route exact name="tag.index" path={TAG_INDEX} component={TagsIndex}/>
        <Route exact name="tag.create" path={TAG_CREATE} component={TagCreate}/>
        <Route exact name="tag.view" path={TAG_VIEW} component={TagView}/>
        <Route exact name="tag.update" path={TAG_UPDATE} component={TagUpdate}/>
        <Route exact name="location.view" path={LOCATION_INDEX} component={LocationsIndex}/>
        <Route exact name="location.index" path={LOCATION_VIEW} component={LocationView}/>
        <Route exact name="index" path={INDEX} component={IndexPage}/>
        <Route path="/" component={NotFoundPage}/>
      </Switch>
    </div>
  )
}

export default PageSwitcher
