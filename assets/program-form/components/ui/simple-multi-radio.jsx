import React from 'react'
import { useDispatch } from 'react-redux'

import RadioButton from './radio-button'
import { TextInput } from './input'

import css from './simple-multi-radio.scss?'


const SimpleMultiRadio = ({title = '', options, selectedValues, setValues}) => {
  const dispatch = useDispatch()

  const handleChooseValue = (id) => {
    let values
    if (selectedValues.values.indexOf(id) === -1) {
      values = [...selectedValues.values, id]
    } else {
      values = selectedValues.values.filter(item => item !== id)
    }

    dispatch(setValues(values, selectedValues.otherValue))
  }

  const renderOptions = () => {
    return options.map((item, key) => {
      return (
        <RadioButton
          key={key}
          click={() => handleChooseValue(item.id)}
          checked={selectedValues.values.indexOf(item.id) !== -1}
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
        {renderOptions()}
        <RadioButton
          click={() => handleChooseValue(0)}
          checked={selectedValues.values.indexOf(0) !== -1}
        >
          <TextInput
            placeholder={'Другой варинт'}
            medium={true}
            value={selectedValues.otherValue}
            setValue={(value) => dispatch(setValues(selectedValues.values, value))}
          />
        </RadioButton>
      </div>
    </>
  )
}

export default SimpleMultiRadio
