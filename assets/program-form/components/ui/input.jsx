import React from 'react'

import css from './input.scss?module'
import cn from 'classnames'


export const TextInput = ({placeholder = '', value, disabled = false, required = false, setValue, big = false}) => {
  return (
    <div className={cn(
      css.input,
      {[css.big]: big},
      {[css.required]: required},
    )}
    >
      <input
        type={'text'}
        value={value}
        placeholder={placeholder}
        required={required}
        disabled={disabled}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export const NumberInput = ({placeholder = '', value, disabled = false, required = false, setValue, small = false}) => {
  const onChange = (event) => {
    const eventValue = Number(event.target.value.replace(/[^.\d]+/g, ''))
    if (eventValue <= 0) {
      setValue(0)
    } else if (eventValue > 999999) {
      setValue(999999)
    } else {
      setValue(String(eventValue))
    }
  }

  return (
    <div className={cn(
      css.input,
      {[css.small]: small},
      {[css.required]: required},
    )}
    >
      <input
        type={'text'}
        min={0}
        value={value}
        placeholder={placeholder}
        required={required}
        disabled={disabled}
        onChange={(event) => onChange(event)}
      />
    </div>
  )
}

export const Textarea = ({placeholder = '', value, setValue, disableResize = true, large = false}) => {
  return (
    <textarea
      className={cn(
        css.textarea,
        {[css.resizeDisabled]: disableResize},
        {[css.large]: large},
      )}
      placeholder={placeholder}
      value={value}
      onChange={(event) => setValue(event.target.value)}
    />
  )
}
