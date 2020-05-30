import React from 'react'

import {useSelector} from 'react-redux'

import BreadcrumbItem from './item'

import css from './breadcrumbs.scss?module'


const Breadcrumbs = ({items = []}) => {
  const title = useSelector(state => state.title)

  return (
    <div className={css.wrap}>
      <ol className={css.breadcrumb}>
        {
          items.map((item, key) => {
            return (<BreadcrumbItem key={key} item={item}/>)
          })
        }
        <BreadcrumbItem item={{
          title: title,
          link: null,
        }}/>
      </ol>
    </div>
  )
}

export default Breadcrumbs
