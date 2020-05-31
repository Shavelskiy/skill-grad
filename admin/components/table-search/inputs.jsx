import React from 'react'

import Select from '../ui/select'

import { LIST, NUMBER, STRING } from './types'

import css from './inputs.scss?module'


const TextInput = ({value, field, changeSearch}) => {
  return (
    <input
      type="text"
      onBlur={() => changeSearch(true)}
      onKeyUp={(event) => event.keyCode === 13 ? changeSearch(true) : {}}
      value={(value !== null) ? value : ''}
      onChange={(event) => changeSearch(false, field, event.target.value)}
    />
  )
}

const NumberInput = ({value, field, changeSearch}) => {
  const changeValue = (inputValue) => {
    if (inputValue > 99999999) {
      inputValue = 99999999
    }

    if (inputValue < -999999) {
      inputValue = -999999
    }

    changeSearch(false, field, inputValue)
  }

  return (
    <input
      type="number"
      onBlur={() => changeSearch(true)}
      onKeyUp={(event) => event.keyCode === 13 ? changeSearch(true) : {}}
      value={(value !== null) ? value : ''}
      onChange={(event) => changeValue(event.target.value)}
    />
  )
}

const ListInput = ({value, filed, options, changeSearch}) => {
  return (
    <Select
      options={options.enum}
      value={value}
      setValue={(inputValue) => changeSearch(true, filed, inputValue)}
    />
  );
}

const SerachItem = ({options, field, search, changeSearch}) => {
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
          />
        )
      case NUMBER:
        return (
          <NumberInput
            field={field}
            value={value}
            changeSearch={changeSearch}
          />
        )
      case LIST:
        return (
          <ListInput
            filed={field}
            value={value}
            options={options}
            changeSearch={changeSearch}
          />
        )
      default:
        return <></>
    }
  }

  return (
    <th className={css.search}>
      {renderInput()}
    </th>
  )
}

export default SerachItem
