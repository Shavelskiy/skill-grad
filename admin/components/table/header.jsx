import React from 'react'

import css from './table.scss?module'
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

  let totalWidth = 0
  table.forEach(item => {
    totalWidth += item.width
  })

  return (
    <div className={css.header}>
      <div className={cn(css.col, css.numbering)}>
        <div className={css.content}></div>
      </div>
      {
        table.map((item, key) => {
          const orderClass = (order[item.name] === 'asc') ? css.asc :
            ((order[item.name] === 'desc') ? css.desc : '')

          return (
            <div
              key={key}
              className={cn(css.orderable, orderClass, css.col)}
              style={{flex: item.width * 45 / totalWidth}}
              onClick={() => changeOrder(item.name)}
            >
              <div className={css.content}>{item.title}</div>
            </div>
          )
        })
      }
      {hasActions ?
        <div className={cn(css.col, css.actions)}>
          <div className={css.content}>Действия</div>
        </div> :
        <></>
      }
    </div>
  )
}

export default TableHeader
