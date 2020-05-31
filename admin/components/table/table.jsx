import React from 'react'
import { Link } from 'react-router-dom'

import TableHeader from './header'
import TableSearch from './search'
import TableBody from './body'

import css from './table.scss?module'
import cn from 'classnames'


const Table = ({table, body, order, search, hasActions, actions, disabled, changeSearch, changeOrder, reload}) => {
  return (
    <table className={cn(css.table, {[css.disabled]: disabled})}>
      <TableHeader
        table={table}
        order={order}
        changeOrder={changeOrder}
        hasActions={actions.length >= 1}
      />
      <TableSearch
        table={table}
        search={search}
        reload={reload}
        changeSearch={changeSearch}
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
