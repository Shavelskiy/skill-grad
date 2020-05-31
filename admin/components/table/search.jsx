import React, { useState } from 'react'

import css from './search.scss?module'
import { NUMBER, STRING } from './searchTypes'


const TextInput = ({value, field, changeSearch, submit}) => {
  return (
    <input
      type="text"
      onBlur={() => submit()}
      onKeyUp={(event) => event.keyCode === 13 ? submit() : {}}
      value={(value !== null) ? value : ''}
      onChange={(event) => changeSearch(field, event.target.value)}
    />
  )
}

const NumberInput = ({value, field, changeSearch, submit}) => {
  const changeValue = (inputValue) => {
    if (inputValue > 99999999) {
      inputValue = 99999999
    }

    if (inputValue < -999999) {
      inputValue = -999999
    }

    changeSearch(field, inputValue)
  }

  return (
    <input
      type="number"
      onBlur={() => submit()}
      onKeyUp={(event) => event.keyCode === 13 ? submit() : {}}
      value={(value !== null) ? value : ''}
      onChange={(event) => changeValue(event.target.value)}
    />
  )
}

const SerachItem = ({options, field, search, changeSearch, submit}) => {
  if (!options.enable) {
    return <th></th>
  }

  const value = (search[field]) ? search[field] : null

  const renderInput = () => {
    switch (options.type) {
      case STRING:
        return (
          <TextInput
            field={field}
            value={value}
            changeSearch={changeSearch}
            submit={submit}
          />
        )
      case NUMBER:
        return (
          <NumberInput
            field={field}
            value={value}
            changeSearch={changeSearch}
            submit={submit}
          />
        )
      default:
        return <th></th>
    }
  }

  return (
    <th className={css.search}>
      {renderInput()}
    </th>
  )
}

const TableSearch = ({table, search, changeSearch, reload, hasActions}) => {
  const [hasNewQuery, setHasNewQuery] = useState(false)

  const changeValue = (field, value) => {
    if (value.length === 0) {
      let tmpSearch = search
      delete (tmpSearch[field])
      changeSearch(tmpSearch)
    } else {
      changeSearch({...search, [field]: value})
    }
    setHasNewQuery(true)
  }

  const submit = () => {
    if (!hasNewQuery) {
      return
    }
    reload()
    setHasNewQuery(false)
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
              search={search}
              changeSearch={changeValue}
              submit={submit}
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
