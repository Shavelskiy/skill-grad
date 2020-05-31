import React from 'react'

import css from './header.scss?module'
import cn from 'classnames'


const TableHeader = ({table, order, setOrder, hasActions}) => {
  const changeOrder = (field) => {
    if (order[field] === 'desc') {
      setOrder({})
    } else if (order[field] === 'asc') {
      setOrder({[field]: 'desc'})
    } else {
      setOrder({[field]: 'asc'})
    }
  }

  return (
    <thead>
    <tr>
      <th></th>
      {
        table.map((item, key) => {
          const orderClass = (order[item.name] === 'asc') ? css.asc :
            ((order[item.name] === 'desc') ? css.desc : '')

          return (
            <th
              key={key}
              className={cn(css.orderable, orderClass)}
              onClick={() => changeOrder(item.name)}
            >
              {item.title}
            </th>
          )
        })
      }
      {hasActions ? <th>Действия</th> : <></>}
    </tr>
    </thead>
  )
}

export default TableHeader
