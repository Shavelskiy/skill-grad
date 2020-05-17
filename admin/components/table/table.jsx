import React from 'react'
import { Link } from 'react-router-dom'

import TableHeader from './header'
import TableSearch from './search'
import TableBody from './body'

import css from './table.scss?module'
import cx from 'classnames'


const Table = ({table, body, order, hasActions, actions, disabled, changeOrder, reload}) => {
  return (
    <table className={cx(css.table, {[css.disabled]: disabled })}>
      <TableHeader
        table={table}
        order={order}
        changeOrder={changeOrder}
        hasActions={actions.length >= 1}
      />
      {/*<TableSearch*/}
      {/*  table={table}*/}
      {/*  order={order}*/}
      {/*  changeOrder={changeOrder}*/}
      {/*  hasActions={actions.length >= 1}*/}
      {/*/>*/}
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
