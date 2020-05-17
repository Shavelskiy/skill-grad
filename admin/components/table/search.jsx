import React from 'react'


const TableSearch = ({table, hasActions}) => {
  return (
    <tbody>
    <tr>
      <th></th>
      {
        table.map((item, key) => {
          return (
            <th
              key={key}
            >
              <input/>
            </th>
          )
        })
      }
      {hasActions ? <th></th> : <></>}
    </tr>
    </tbody>
  )
}

export default TableSearch
