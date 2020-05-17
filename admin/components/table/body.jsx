import React from 'react'

import TableActions from './actions'

import css from './body.scss?module'


const TableBody = ({body, table, actions, reload}) => {
  return (
    <tbody>
    {
      body.map((bodyItem, key) => {
        const row = table.map((item, key) => {
          return (
            <td key={key}>
              {bodyItem[item.name]}
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
