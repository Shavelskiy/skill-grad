import React, { useState, useEffect } from 'react'

import SerachItem from './inputs'


const TableSearch = ({table, tableSearch, changeSearch, hasActions}) => {
  const [search, setSearch] = useState(null)

  useEffect(() => {
    setSearch({
      query: tableSearch,
      isNew: false,
      submit: false,
    })
  }, [tableSearch])

  useEffect(() => {
    if (search === null || !search.submit || !search.isNew) {
      return
    }

    setSearch({...search, isNew: false})
    changeSearch(search.query)
  }, [search])

  const changeValue = (submit, field = null, value = null) => {
    let newQuery = search.query
    let isNew = search.isNew

    if (field !== null) {
      isNew = true
      if (value !== null && value.length > 0) {
        newQuery[field] = value
      } else {
        delete newQuery[field]
      }
    }

    setSearch({
      query: newQuery,
      isNew: isNew,
      submit: submit,
    })
  }

  return (
    <tbody>
    <tr>
      <th></th>
      {
        table.map((item, key) => {
          return (
            <SerachItem
              key={key}
              options={item.search}
              field={item.name}
              search={(search !== null) ? search.query : {}}
              changeSearch={changeValue}
            />
          )
        })
      }
      {hasActions ? <th></th> : <></>}
    </tr>
    </tbody>
  )
}

export default TableSearch
