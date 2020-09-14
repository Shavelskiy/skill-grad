import React from 'react'

import css from './table.scss?module'

const Table = ({children, headers, withEmpty = false}) => {
  return (
    <table className={css.table}>
      <thead>
      <tr>
        {headers.map((item, key) => <th key={key}>{item}</th>)}
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
