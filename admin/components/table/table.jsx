import React from 'react'
import { Link } from 'react-router-dom'

import TableHeader from './header'
import TableBody from './body'

import css from './table.scss'


const Table = ({table, body, order, hasActions, actions, disabled, changeOrder, reload}) => {
  return (
    <table className={`table ${disabled ? 'disabled' : ''}`}>
      <TableHeader
        table={table}
        order={order}
        changeOrder={changeOrder}
        hasActions={actions.length >= 1}
      />
      <TableBody
        body={body}
        table={table}
        actions={actions}
        reload={reload}
      />
    </table>
  )
}

export default Table
