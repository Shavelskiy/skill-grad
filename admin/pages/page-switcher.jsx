import React from 'react'
import { Switch, Route } from 'react-router-dom'

import css from './page-switcher.scss?module'
import cn from 'classnames'

import {
  INDEX,
  CATEGORY_INDEX,
  CATEGORY_VIEW,
  CATEGORY_UPDATE,
  ARTICLE_INDEX,
  ARTICLE_CREATE,
  ARTICLE_VIEW,
  ARTICLE_UPDATE,
  USER_INDEX,
  LOCATION_INDEX,
  LOCATION_VIEW,
  CATEGORY_CREATE,
  PROGRAM_FORMAT_INDEX,
  PROGRAM_FORMAT_CREATE,
  PROGRAM_FORMAT_UPDATE,
  PROVIDER_INDEX,
  PROVIDER_CREATE,
  LOCATION_CREATE,
  LOCATION_UPDATE,
  PROVIDER_UPDATE,
  PROVIDER_VIEW,
  PROGRAM_ADDITIONAL_INDEX,
  PROGRAM_ADDITIONAL_CREATE,
  PROGRAM_ADDITIONAL_UPDATE,
  PROGRAM_INCLUDE_INDEX,
  PROGRAM_INCLUDE_UPDATE,
  PROGRAM_INCLUDE_CREATE,
  PROGRAM_LEVEL_INDEX,
  PROGRAM_LEVEL_UPDATE,
  PROGRAM_LEVEL_CREATE,
  FEEDBACK_INDEX, FEEDBACK_VIEW,
  PRICES_INDEX,
  PRICES_UPDATE,
  FAQ_INDEX,
  FAQ_CREATE,
  FAQ_VIEW,
  FAQ_UPDATE,
  PAGE_INDEX,
  PAGE_CREATE,
  PAGE_VIEW,
  PAGE_UPDATE,
  SEO_INDEX,
  SEO_ARTICLE_INDEX,
  SEO_PROVIDER_INDEX,
  SEO_PROGRAM_INDEX,
  SEO_PAGE_INDEX,
} from './../utils/routes'

import Breadcrumbs from '../components/breadcrumbs/breacrumbs'
import NotFoundPage from '../pages/not-found/not-found'
import IndexPage from './'
import CategoryIndex from './category'
import CategoryView from './category/view'
import CategoryCreate from './category/create'
import CategoryUpdate from './category/update'
import ProgramFormatIndex from './program-format'
import ProgramFormatCreate from './program-format/create'
import ProgramFormatUpdate from './program-format/update'
import ProviderIndex from './provider'
import ProviderCreate from './provider/create'
import ProviderView from './provider/view'
import ProviderUpdate from './provider/update'
import ArticleIndex from './articles'
import ArticleCreate from './articles/create'
import ArticleView from './articles/view'
import ArticleUpdate from './articles/update'
import UsersIndex from './users'
import LocationsIndex from '../pages/locations'
import LocationCreate from './locations/create'
import LocationView from '../pages/locations/view'
import LocationUpdate from './locations/update'
import ProgramAdditionalIndex from './program-additional'
import ProgramAdditionalCreate from './program-additional/create'
import ProgramAdditionalUpdate from './program-additional/update'
import ProgramIncludeIndex from './program-include'
import ProgramIncludeUpdate from './program-include/update'
import ProgramIncludeCreate from './program-include/create'
import ProgramLevelIndex from './program-level'
import ProgramLevelCreate from './program-level/create'
import ProgramLevelUpdate from './program-level/update'
import FeedbackIndex from './feedback'
import FeedbackView from './feedback/view'
import PriceIndex from './price'
import PriceUpdate from './price/update'
import FaqIndex from './faq'
import FaqCreate from './faq/create'
import FaqView from './faq/view'
import FaqUpdate from './faq/update'
import PageIndex from './page'
import PageCreate from './page/create'
import PageView from './page/view'
import PageUpdate from './page/update'
import SeoIndex from './seo/seo-index'
// todo
import SeoArticleIndex from './seo/seo-article-index'
// todo
import SeoProviderIndex from './seo/seo-provider-index'
// todo
import SeoProgramIndex from './seo/seo-program-index'
// todo
import SeoPageIndex from './seo/seo-page-index'
// todo


const PageSwitcher = ({active}) => {
  return (
    <div className={cn(css.page, {[css.hidden]: !active})}>
      <Breadcrumbs/>

      <div className={css.content}>
        <Switch>
          <Route exact name="category.index" path={CATEGORY_INDEX} component={CategoryIndex}/>
          <Route exact name="category.create" path={CATEGORY_CREATE} component={CategoryCreate}/>
          <Route exact name="category.view" path={CATEGORY_VIEW} component={CategoryView}/>
          <Route exact name="category.update" path={CATEGORY_UPDATE} component={CategoryUpdate}/>

          <Route exact name="program-format.index" path={PROGRAM_FORMAT_INDEX} component={ProgramFormatIndex}/>
          <Route exact name="program-format.create" path={PROGRAM_FORMAT_CREATE} component={ProgramFormatCreate}/>
          <Route exact name="program-format.update" path={PROGRAM_FORMAT_UPDATE} component={ProgramFormatUpdate}/>

          <Route exact name="program-additional.index" path={PROGRAM_ADDITIONAL_INDEX}
                 component={ProgramAdditionalIndex}/>
          <Route exact name="program-additional.create" path={PROGRAM_ADDITIONAL_CREATE}
                 component={ProgramAdditionalCreate}/>
          <Route exact name="program-additional.update" path={PROGRAM_ADDITIONAL_UPDATE}
                 component={ProgramAdditionalUpdate}/>

          <Route exact name="program-include.index" path={PROGRAM_INCLUDE_INDEX} component={ProgramIncludeIndex}/>
          <Route exact name="program-include.create" path={PROGRAM_INCLUDE_CREATE} component={ProgramIncludeCreate}/>
          <Route exact name="program-include.update" path={PROGRAM_INCLUDE_UPDATE} component={ProgramIncludeUpdate}/>

          <Route exact name="program-level.index" path={PROGRAM_LEVEL_INDEX} component={ProgramLevelIndex}/>
          <Route exact name="program-level.create" path={PROGRAM_LEVEL_CREATE} component={ProgramLevelCreate}/>
          <Route exact name="program-level.update" path={PROGRAM_LEVEL_UPDATE} component={ProgramLevelUpdate}/>

          <Route exact name="provider.index" path={PROVIDER_INDEX} component={ProviderIndex}/>
          <Route exact name="provider.create" path={PROVIDER_CREATE} component={ProviderCreate}/>
          <Route exact name="provider.view" path={PROVIDER_VIEW} component={ProviderView}/>
          <Route exact name="provider.update" path={PROVIDER_UPDATE} component={ProviderUpdate}/>

          <Route exact name="article.index" path={ARTICLE_INDEX} component={ArticleIndex}/>
          <Route exact name="article.create" path={ARTICLE_CREATE} component={ArticleCreate}/>
          <Route exact name="article.view" path={ARTICLE_VIEW} component={ArticleView}/>
          <Route exact name="article.update" path={ARTICLE_UPDATE} component={ArticleUpdate}/>

          <Route exact name="user.index" path={USER_INDEX} component={UsersIndex}/>

          <Route exact name="location.index" path={LOCATION_INDEX} component={LocationsIndex}/>
          <Route exact name="location.create" path={LOCATION_CREATE} component={LocationCreate}/>
          <Route exact name="location.view" path={LOCATION_VIEW} component={LocationView}/>
          <Route exact name="location.update" path={LOCATION_UPDATE} component={LocationUpdate}/>

          <Route exact name="feedback.index" path={FEEDBACK_INDEX} component={FeedbackIndex}/>
          <Route exact name="feedback.view" path={FEEDBACK_VIEW} component={FeedbackView}/>

          <Route exact name="price.index" path={PRICES_INDEX} component={PriceIndex}/>
          <Route exact name="price.update" path={PRICES_UPDATE} component={PriceUpdate}/>

          <Route exact name="faq.index" path={FAQ_INDEX} component={FaqIndex}/>
          <Route exact name="faq.create" path={FAQ_CREATE} component={FaqCreate}/>
          <Route exact name="faq.view" path={FAQ_VIEW} component={FaqView}/>
          <Route exact name="faq.update" path={FAQ_UPDATE} component={FaqUpdate}/>

          <Route exact name="page.index" path={PAGE_INDEX} component={PageIndex}/>
          <Route exact name="page.create" path={PAGE_CREATE} component={PageCreate}/>
          <Route exact name="page.view" path={PAGE_VIEW} component={PageView}/>
          <Route exact name="page.update" path={PAGE_UPDATE} component={PageUpdate}/>

          <Route exact name="seo.index" path={SEO_INDEX} component={SeoIndex}/>
          {/*<Route exact name="seo.update" path={PRICES_UPDATE} component={PriceUpdate}/>*/}

          <Route exact name="seo-article.index" path={SEO_ARTICLE_INDEX} component={SeoArticleIndex}/>
          {/*<Route exact name="price.update" path={PRICES_UPDATE} component={PriceUpdate}/>*/}

          <Route exact name="seo-provider.index" path={SEO_PROVIDER_INDEX} component={SeoProviderIndex}/>
          {/*<Route exact name="price.update" path={PRICES_UPDATE} component={PriceUpdate}/>*/}

          <Route exact name="seo-program.index" path={SEO_PROGRAM_INDEX} component={SeoProgramIndex}/>
          {/*<Route exact name="price.update" path={PRICES_UPDATE} component={PriceUpdate}/>*/}

          <Route exact name="seo-page.index" path={SEO_PAGE_INDEX} component={SeoPageIndex}/>
          {/*<Route exact name="price.update" path={PRICES_UPDATE} component={PriceUpdate}/>*/}

          <Route exact name="index" path={INDEX} component={IndexPage}/>
          <Route path="/" component={NotFoundPage}/>
        </Switch>
      </div>
    </div>
  )
}

export default PageSwitcher
