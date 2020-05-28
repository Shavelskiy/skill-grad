import React from 'react'

import {useSelector} from 'react-redux'

import BreadcrumbItem from './item'

import css from './breadcrumbs.scss'


const Breadcrumbs = ({items}) => {
  const title = useSelector(state => state.title)

  const lastItem = {
    title: title,
    link: null,
  }

  return (
    <div className="breadcrumb-wrap">
      <ol className="breadcrumb">
        {
          items.map((item, key) => {
            return (<BreadcrumbItem key={key} item={item}/>)
          })
        }
        <BreadcrumbItem item={lastItem}/>
      </ol>
    </div>
  )
}

export default Breadcrumbs
