import React from 'react'

import InputMask from 'react-input-mask'

import css from './input.scss?module'


export const Input = ({type, placeholder, value, setValue}) => {
  return (
    <input
      type={type}
      className={css.input}
      placeholder={placeholder}
      value={value}
      onChange={({target}) => setValue(target.value)}
      autoComplete={'off'}
    />
  )
}

export const MaskInput = ({mask, value, setValue}) => {
  return (
    <InputMask
      className={css.input}
      mask={mask}
      value={value}
      onChange={({target}) => setValue(target.value)}
      alwaysShowMask={true}
    />
  )
}

export const Textarea = ({placeholder, rows, value, setValue}) => {
  return (
    <textarea
      className={css.textarea}
      rows={rows}
      placeholder={placeholder}
      value={value}
      onChange={({target}) => setValue(target.value)}
    ></textarea>
  )
}