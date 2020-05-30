import React from 'react'

import css from './head.scss?module'
import cx from 'classnames'


const TableHeader = ({table, order, changeOrder, hasActions}) => {
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
              className={cx(css.orderable, orderClass)}
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
