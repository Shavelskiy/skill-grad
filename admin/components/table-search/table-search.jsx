import React, { useState, useEffect } from 'react'

import SerachItem from './inputs'

import css from './../table/table.scss?module'
import cn from 'classnames'


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

    if (JSON.stringify(search.query) === JSON.stringify(tableSearch)) {
      // return
    }

    setSearch({...search, isNew: false})
    changeSearch(search.query)
  }, [search])

  const changeValue = (submit, field = null, value = null) => {
    let newQuery = search.query
    let isNew = search.isNew

    if (field !== null) {
      isNew = true
      if (value !== null && (typeof value === 'boolean' || value.length > 0)) {
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

  let totalWidth = 0
  table.forEach(item => {
    totalWidth += item.width
  })

  return (
    <div className={css.search}>
      <div className={cn(css.col, css.numbering)}></div>
      {
        table.map((item, key) => {
          return (
            <div
              key={key}
              className={css.col}
              style={{flex: item.width * 45 / totalWidth}}
            >
              <SerachItem
                options={item.search}
                field={item.name}
                search={(search !== null) ? search.query : {}}
                changeSearch={changeValue}
              />
            </div>
          )
        })
      }
      {hasActions ? <div className={cn(css.col, css.actions)}></div> : <></>}
    </div>
  )
}

export default TableSearch
