import React from 'react'

import Select from '../ui/select'

import { BOOL, LIST, NUMBER, STRING } from './types'
import close from './../../images/close.svg'

import css from './inputs.scss?module'


const Input = ({value, field, changeSearch, isNumber = false}) => {
  const changeValue = (inputValue) => {
    if (isNumber) {
      if (inputValue > 99999999) {
        inputValue = 99999999
      }

      if (inputValue < -999999) {
        inputValue = -999999
      }
    }

    changeSearch(false, field, inputValue)
  }

  return (
    <div className={css.input}>
      <input
        type={isNumber ? 'number' : 'text'}
        onBlur={() => changeSearch(true)}
        onKeyUp={(event) => event.keyCode === 13 ? changeSearch(true) : {}}
        value={(value !== null) ? value : ''}
        onChange={(event) => changeValue(event.target.value)}
      />
      <img
        src={close}
        className={css.close}
        onClick={() => (value !== null && value !== '') ? changeSearch(true, field, null) : {}}
      />
    </div>
  )
}

const ListInput = ({value, field, options, changeSearch}) => {
  return (
    <Select
      options={options.enum}
      value={value}
      setValue={(inputValue) => changeSearch(true, field, inputValue)}
      high={true}
    />
  )
}

const BoolInput = ({value, field, changeSearch}) => {
  const options = [
    {title: 'Да', value: true},
    {title: 'Нет', value: false},
  ]

  return (
    <Select
      options={options}
      value={value}
      canUncheck={true}
      setValue={(inputValue) => changeSearch(true, field, inputValue)}
      high={true}
    />
  )
}

const SerachItem = ({options, field, search, changeSearch}) => {
  if (!options.enable) {
    return <div></div>
  }

  const value = (typeof search[field] !== 'undefined') ? search[field] : null

  const renderInput = () => {
    switch (options.type) {
      case STRING:
      case NUMBER:
        return (
          <Input
            field={field}
            value={value}
            changeSearch={changeSearch}
            isNumber={options.type === NUMBER}
          />
        )
      case LIST:
        return (
          <ListInput
            field={field}
            value={value}
            options={options}
            changeSearch={changeSearch}
          />
        )
      case BOOL:
        return (
          <BoolInput
            field={field}
            value={value}
            changeSearch={changeSearch}
          />
        )
      default:
        return <></>
    }
  }

  return (
    <div className={css.search}>
      {renderInput()}
    </div>
  )
}

export default SerachItem
