import React from 'react'

import Button from './button'

import css from './inputs.scss?module'


export function TextInput({label, value, setValue, disabled = false}) {
  return (
    <div className={css.input}>
      <label>{label}</label>
      <input
        type="text"
        value={value}
        disabled={disabled}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export function NumberInput({label, value, setValue, step = 100}) {
  return (
    <div className={css.input}>
      <label>{label}</label>
      <input
        type="number"
        value={value}
        step={step}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export function SaveButton({handler, disable}) {
  return (
    <div className={css.saveWrap}>
      <Button
        text={'Сохранить'}
        success={true}
        disabled={disable}
        click={handler}
      />
    </div>
  )
}
