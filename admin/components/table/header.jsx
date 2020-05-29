import React from 'react'

const TableHeader = ({table, order, changeOrder, hasActions}) => {
  return (
    <thead>
    <tr>
      <th></th>
      {
        table.map((item, key) => {
          const orderClass = (order[item.name] === 'asc') ? 'asc' :
            ((order[item.name] === 'desc') ? 'desc' : '')

          return (
            <th
              key={key}
              className={`orderable ${orderClass}`}
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
