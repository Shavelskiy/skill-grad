import React from 'react'

import {useSelector} from 'react-redux'

import BreadcrumbItem from './item'

import css from './breadcrumbs.scss?module'


const Breadcrumbs = () => {
  const title = useSelector(state => state.title)
  const breadcrumbs = useSelector(state => state.breadcrumbs)

  return (
    <div className={css.wrap}>
      <ol className={css.breadcrumb}>
        {breadcrumbs.map((item, key) => <BreadcrumbItem key={key} item={item}/>)}
        <BreadcrumbItem item={{
          title: title,
          link: null,
        }}/>
      </ol>
    </div>
  )
}

export default Breadcrumbs
