import React from 'react'

import {DATE, AUTHOR, CONTACT} from './header-types'
import css from './table.scss?module'

const Table = ({children, headers, withEmpty = false}) => {
  const renderHeader = () => {
    return headers.map((item, key) => {
      if (item.type === null) {
        return <th key={key}>{item.title}</th>
      }

      let headerClass = ''

      switch (item.type) {
        case DATE:
          headerClass = css.column__date
          break
        case AUTHOR:
          headerClass = css.column__author
          break
        case CONTACT:
          headerClass = css.column__contact
          break
      }

      return (
        <th key={key} className={headerClass}>
          {item.title}
        </th>
      )
    })
  }

  return (
    <table className={css.table}>
      <thead>
      <tr>
        {renderHeader()}
        {withEmpty ? <th></th> : <></>}
      </tr>
      </thead>
      <tbody>
      {children}
      </tbody>
    </table>
  )
}

export default Table
