import React from 'react'

import TableActions from './actions'

import css from './body.scss?module'
import cn from 'classnames'

const BoolValue = ({isTrue}) => {
  return (
    <div className={css.boolean}>
      <span className={cn(
        {[css.true]: isTrue},
        {[css.false]: !isTrue}
      )}>
        {isTrue ? 'Да' : 'Нет'}
      </span>
    </div>
  )
}

const TableBody = ({body, table, actions, reload}) => {
  return (
    <tbody>
    {
      body.map((bodyItem, key) => {
        const row = table.map((item, key) => {
          let content
          if (typeof bodyItem[item.name] === 'boolean') {
            content = (<BoolValue isTrue={bodyItem[item.name]}/>)
          } else {
            content = (<>{bodyItem[item.name]}</>)
          }

          return (
            <td key={key}>
              {content}
            </td>
          )
        })

        return (
          <tr key={key}>
            <td className={css.numbering}>{key + 1}</td>
            {row}
            <TableActions
              actions={actions}
              item={bodyItem}
              reload={reload}
            />
          </tr>
        )
      })
    }
    </tbody>
  )
}

export default TableBody
