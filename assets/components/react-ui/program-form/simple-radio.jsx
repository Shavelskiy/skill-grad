import React from 'react'
import { useDispatch } from 'react-redux'

import RadioButton from './radio-button'
import { TextInput } from './input'

import css from './scss/simple-radio.scss?module'


const SimpleRadio = ({title = '', options, selectedValue, selectValue}) => {
  const dispatch = useDispatch()

  const renderOptions = () => {
    return options.map((item, key) => {
      return (
        <RadioButton
          key={key}
          click={() => dispatch(selectValue(item.id, selectedValue.otherValue))}
          selected={item.id === selectedValue.id}
        >
          {item.title}
        </RadioButton>
      )
    })
  }

  return (
    <>
      <h3>{title}:</h3>
      <div className={css.simpleRadio}>
        <RadioButton
          click={() => dispatch(selectValue(0, selectedValue.otherValue))}
          selected={selectedValue.id === 0}
        >
          Не выбрано
        </RadioButton>
        {renderOptions()}
        <RadioButton
          click={() => dispatch(selectValue(null, selectedValue.otherValue))}
          selected={selectedValue.id === null}
        >
          <TextInput
            placeholder={'Другой варинт'}
            medium={true}
            value={selectedValue.otherValue}
            setValue={(value) => dispatch(selectValue(selectedValue.id, value))}
          />
        </RadioButton>
      </div>
    </>
  )
}

export default SimpleRadio
