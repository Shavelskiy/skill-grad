import React from 'react'

import TableActions from './actions'
import { IMAGE } from '../../utils/table-item-display'

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
    <tbody className={css.tableBody}>
    {
      body.map((bodyItem, key) => {
        const row = table.map((item, key) => {
          const value = bodyItem[item.name]
          let content
          if (item.display) {
            switch (item.display) {
              case IMAGE:
                content = <img src={value}/>
                break
              default:
                content = <>{value}</>
                break
            }
          } else {
            if (typeof value === 'boolean') {
              content = <BoolValue isTrue={value}/>
            } else {
              content = <>{value}</>
            }
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
