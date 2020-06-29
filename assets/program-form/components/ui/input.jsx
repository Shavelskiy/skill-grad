import React from 'react'

import css from './input.scss?module'
import cn from 'classnames'


export const TextInput = ({placeholder = '', value, disabled = false, setValue, extraSmall = false, small = false, standart = false, medium = false, large = false, extraLarge = false}) => {
  return (
    <div className={cn(
      css.input,
      {[css.extraSmall]: extraSmall},
      {[css.small]: small},
      {[css.standart]: standart},
      {[css.medium]: medium},
      {[css.large]: large},
      {[css.extraLarge]: extraLarge},
    )}
    >
      <input
        type={'text'}
        value={value}
        placeholder={placeholder}
        disabled={disabled}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export const NumberInput = ({
                              placeholder = '', value, maxValue = 9999999, disabled = false, setValue, extraSmall = false, small = false, standart = false, medium = false, large = false, extraLarge = false
                            }) => {
  const onChange = (event) => {
    const eventValue = Number(event.target.value.replace(/[^.\d]+/g, ''))
    if (eventValue <= 0) {
      setValue(0)
    } else if (eventValue > maxValue) {
      setValue(maxValue)
    } else {
      setValue(String(eventValue))
    }
  }

  return (
    <div className={cn(
      css.input,
      {[css.extraSmall]: extraSmall},
      {[css.small]: small},
      {[css.standart]: standart},
      {[css.medium]: medium},
      {[css.large]: large},
      {[css.extraLarge]: extraLarge},
    )}
    >
      <input
        type={'text'}
        min={0}
        value={value}
        placeholder={placeholder}
        disabled={disabled}
        onChange={(event) => onChange(event)}
      />
    </div>
  )
}

export const Textarea = ({placeholder = '', value, setValue, disableResize = true, extraSmall = false, small = false, medium = false, large = false, extraLarge = false, smallText = false}) => {
  return (
    <textarea
      className={cn(
        css.textarea,
        {[css.resizeDisabled]: disableResize},
        {[css.extraSmall]: extraSmall},
        {[css.small]: small},
        {[css.medium]: medium},
        {[css.large]: large},
        {[css.extraLarge]: extraLarge},
        {[css.smallText]: smallText},
      )}
      placeholder={placeholder}
      value={value}
      onChange={(event) => setValue(event.target.value)}
    />
  )
}
