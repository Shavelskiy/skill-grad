import React from 'react'

import TableHeader from './header'
import TableSearch from '../table-search/table-search'
import TableBody from './body'

import css from './table.scss?module'
import cn from 'classnames'


const Table = ({table, body, query, actions, disabled, changeSearch, changeOrder, reload}) => {
  return (
    <div className={cn(css.table, {[css.disabled]: disabled})}>
      <TableHeader
        table={table}
        order={query.order}
        setOrder={changeOrder}
        hasActions={actions.length >= 1}
      />
      <TableSearch
        table={table}
        tableSearch={query.search}
        changeSearch={changeSearch}
        hasActions={actions.length >= 1}
      />
      <TableBody
        body={body}
        table={table}
        actions={actions}
        reload={reload}
      />
    </div>
  )
}

export default Table
